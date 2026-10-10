'use strict'

// Dark skin integration
function switchDark(enabled) {
  if(enabled) {
    chart1.options.scales['y'].grid.borderColor = '#222b41';
    chart1.options.scales['x'].ticks.color = 'rgba(255,255,255,.65)';

    chart2.options.scales['x'].grid.color = '#222b41';
    chart2.options.scales['x'].ticks.color = 'rgba(255,255,255,.65)';
    chart2.options.scales['x'].grid.borderColor = '#222b41';
    chart2.options.scales['y'].grid.color = '#222b41';
    chart2.options.scales['y'].ticks.color = 'rgba(255,255,255,.65)';

    chart2.data.datasets[1].backgroundColor = '#222b41';

    $('.btn-white').addClass('btn-outline-primary').removeClass('btn-white');

  } else {
    chart1.options.scales['y'].grid.borderColor = '#e2e5ec';
    chart1.options.scales['x'].ticks.color = '#313c47';

    chart2.options.scales['x'].grid.color = '#edeff6';
    chart2.options.scales['x'].ticks.color = '#42484e';
    chart2.options.scales['x'].grid.borderColor = '#edeff6';
    chart2.options.scales['y'].grid.color = '#edeff6';
    chart2.options.scales['y'].ticks.color = '#42484e';

    chart2.data.datasets[1].backgroundColor = '#e2e5ec';

    $('.btn-outline-primary').addClass('btn-white').removeClass('btn-outline-primary');
  }

  chart1.update();
  chart2.update();
}

if(skinMode) { switchDark(true); }

// Switch between light and dark
$('#skinMode .nav-link').bind('click', function(e){
  var mode = $(this).text().toLowerCase();
  if(mode == 'dark') {
    switchDark(true);
  } else {
    switchDark(false);
  }
});
