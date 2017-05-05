        </main>
        <footer class="footer">
            <div class="container-fluid">
                <p class="text-muted">
                    Sistema de Gerencimento de Fichas &copy; 2017<br>
                    <small>Power by <a href="#">Asterisco Soluções</a></small>
                </p>
            </div>
        </footer>
        <script src="public/js/jquery-3.1.1.min.js"></script>
        <script src="public/js/bootstrap.min.js"></script>
        <script src="public/js/jquery.mask.min.js"></script>
        <script>
            $(document).on('click', '.delete', function(event) {
                event.preventDefault();
                result = confirm('Deseja realmente apagar o registro?');
                if (result) {
                    window.location.href = $(this).attr('href');
                }
            });
            $(function(){
                $('.date').mask('00/00/0000');
            });

            $(document).on('blur', '.ficha', function(event) {
                $.get('<?=self::link("alunos/")?>'+$(this).val()).done(function(data) {
                    if ($.parseJSON(data).status == true && $('#alunos-form').data('submit') == 'create') {
                        $('.alert-error-form').fadeIn('fast');
                        $('.aluno-submit').attr('disabled', 'disabled');
                    } else {
                        $('.alert-error-form').fadeOut('fast');
                        $('.aluno-submit'). removeAttr('disabled');
                    }
                });
            });
        </script>
    </body>
</html>