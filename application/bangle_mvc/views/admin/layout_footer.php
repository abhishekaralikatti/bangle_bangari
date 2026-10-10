    </div><!-- /p-3 -->
</div><!-- /#main -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mobile sidebar toggle
    document.getElementById('sidebar-toggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
    // Image preview
    const imgInput = document.getElementById('image');
    if (imgInput) {
        imgInput.addEventListener('change', function() {
            const preview = document.getElementById('image-preview');
            if (this.files && this.files[0] && preview) {
                preview.src = URL.createObjectURL(this.files[0]);
                preview.classList.remove('d-none');
            }
        });
    }
</script>
</body>
</html>
