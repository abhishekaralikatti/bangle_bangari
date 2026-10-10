<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cron Controller
 * ────────────────────────────────────────────────────────
 * Set up a cron job on your server to run daily at 7AM:
 *
 *   0 7 * * * curl -s "https://yourdomain.com/cron/send_horoscopes/YOUR_CRON_SECRET" >> /dev/null 2>&1
 *
 * Replace YOUR_CRON_SECRET with a long random string and
 * set the same value in config.php as 'cron_secret'.
 */
class Cron extends CI_Controller {

    // ── Change this to a long random secret string ─────────────────────
    private $cron_secret = 'CHANGE_THIS_TO_A_RANDOM_SECRET';

    public function __construct() {
        parent::__construct();
        $this->load->model(['User_model', 'Horoscope_model']);
    }

    public function send_horoscopes($token = '') {
        // Validate cron secret
        if ($token !== $this->cron_secret) {
            show_error('Unauthorized', 403);
            return;
        }

        $users = $this->User_model->get_subscribed_users();
        $today = date('Y-m-d');
        $sent  = 0;
        $failed = 0;

        foreach ($users as $user) {
            $horoscope = $this->Horoscope_model->get_todays_horoscope($user->id, $user->zodiac_sign);

            if (!$horoscope) {
                $failed++;
                continue;
            }

            // Skip if already emailed today
            if (isset($horoscope->email_sent) && $horoscope->email_sent) {
                continue;
            }

            $result = $this->_send_horoscope_email($user, $horoscope);

            if ($result) {
                $this->Horoscope_model->mark_email_sent($user->id, $today);
                $this->Horoscope_model->log_email($user->id, $user->email, 'Your Daily Horoscope – ' . date('d M Y'), 'sent');
                $sent++;
            } else {
                $this->Horoscope_model->log_email($user->id, $user->email, 'Your Daily Horoscope – ' . date('d M Y'), 'failed');
                $failed++;
            }

            // Small delay to avoid SMTP rate limiting
            usleep(200000);
        }

        echo json_encode([
            'status' => 'done',
            'date'   => $today,
            'sent'   => $sent,
            'failed' => $failed
        ]);
    }

    private function _send_horoscope_email($user, $horoscope) {
        $this->load->library('email');
        $this->email->initialize([
            'protocol'   => 'smtp',
            'smtp_host'  => $this->config->item('smtp_host'),
            'smtp_user'  => $this->config->item('smtp_user'),
            'smtp_pass'  => $this->config->item('smtp_pass'),
            'smtp_port'  => $this->config->item('smtp_port'),
            'smtp_crypto'=> 'tls',
            'mailtype'   => 'html',
            'charset'    => 'UTF-8',
            'from_email' => $this->config->item('from_email'),
            'from_name'  => $this->config->item('from_name'),
        ]);

        $this->email->to($user->email);
        $this->email->subject('✨ Your Daily Horoscope – ' . date('d M Y'));

        $message = $this->load->view('email_templates/daily_horoscope', [
            'user'      => $user,
            'horoscope' => $horoscope,
            'date'      => date('l, d F Y')
        ], TRUE);

        $this->email->message($message);
        return $this->email->send();
    }
}
