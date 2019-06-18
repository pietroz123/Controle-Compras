            </div>
            <!-- Div conteudo-principal -->
        </div>
        <!-- Div container -->

        <footer class="footer" id="footer-principal">

            <!-- Container -->
            <div class="container pt-4 pb-2 px-5 bg-dark">

                <!-- Titulo -->
                <div class="row mb-4">
                    <div class="col">
                        <div class="titulo-site-footer white-text">Controle de Compras</div>
                    </div>
                </div>
                
                <!-- Navegacao -->
                <nav class="nav-footer d-flex justify-content-around flex-column flex-md-row">
                    <a class="text-center footer-nav-item" href="index.php">Home</a>
                    <?php
                        if (usuario_esta_logado()) {
                    ?>
                        <a class="text-center footer-nav-item" href="perfil-usuario.php">Meu Perfil</a>
                        <a class="text-center footer-nav-item" href="formulario-compra.php">Adicionar Compra</a>
                        <a class="text-center footer-nav-item" href="compras.php">Compras</a>
                        <a class="text-center footer-nav-item" href="busca.php">Buscar</a>
                        <a class="text-center footer-nav-item" href="relatorios.php">Relatórios</a>
                    <?php
                        }
                    ?>
                </nav>

                <hr class="mt-4 mb-3">

                <!-- Copyright e Redes Sociais -->
                <div class="row py-2 white-text">
                    <div class="col-sm-12 col-md">
                        <div class="footer-copyright"><b>&copy; 2018</b>: Pietro Zuntini Bonfim</div>
                    </div>
                    <div class="col-sm-12 col-md">
                        <div class="icones-redes">
                            <!-- Gitlab -->
                            <a href="https://gitlab.com/pietroz123" class="gitlab-ic white-text">
                                <i class="fab fa-gitlab fa-2x"></i>
                            </a>
                            <!-- Github -->
                            <a href="https://github.com/pietroz123" class="github-ic white-text ml-3">
                                <i class="fab fa-github fa-2x"></i>
                            </a>
                            <!-- Linkedin -->
                            <a href="https://www.linkedin.com/in/pietro-zuntini-b23506140/" class="linkedin-ic white-text ml-3">
                                <i class="fab fa-linkedin fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Container -->

        </footer>

        <!-- Scripts (Javascript) -->
        <script src="lib/jquery/js/jquery-latest.js"></script>                                                      <!-- JQuery -->
        <script src="lib/jquery-ui/js/jquery-ui.js"></script>                                                       <!-- JQuery UI -->
        <script src="lib/popper/js/popper.min.js"></script>                                                         <!-- Popper -->
        <script src="lib/mdbootstrap/js/bootstrap.js"></script>                                                     <!-- Boostrap -->
        <script src="lib/mdbootstrap/js/mdb.js"></script>                                                           <!-- MDBootstrap -->
        <script src="lib/mdbootstrap/js/datatables.js"></script>                                                    <!-- MDBootstrap / Datatables -->
        <script src="lib/mdbootstrap/js/datatables-responsive.js"></script>                                         <!-- Datatables Responsive -->
        <script src="lib/select2/js/select2.js"></script>                                                           <!-- Select2 -->
        <script src="lib/jquery-mask/js/jquery.mask.js"></script>                                                   <!-- JQuery Masks -->
        <script src="lib/bootstrap-confirmation/js/bootstrap-confirmation.js"></script>                             <!-- Boostrap Confirmation -->
        <script src="lib/cropper/js/cropper.js"></script>                                                           <!-- Cropper -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>                <!-- Toastr -->
        <script src="lib/air-datepicker/js/datepicker.js"></script>                                                 <!-- Air Datepicker -->
        <script src="lib/air-datepicker/js/datepicker.pt-BR.js"></script>                                           <!-- Air Datepicker PT-BR -->
        <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>      <!-- Code Prettify -->
        <script src="lib/code-prettify/js/lang/lang-sql.js"></script>                                               <!-- Code Prettify / SQL -->
        <script src="lib/amcharts-v4/core.js"></script>                                                             <!-- AmCharts -->
        <script src="lib/amcharts-v4/charts.js"></script>
        <script src="lib/amcharts-v4/themes/animated.js"></script>                                                  <!-- Main -->

        <script src="js/main.js"></script>


    </body>

</html>