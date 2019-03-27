            </div>
            <!-- Div conteudo-principal -->
        </div>
        <!-- Div container -->

        <footer class="footer">

            <!-- Container -->
            <div class="container pt-4 pb-2 px-5 bg-dark">

                <!-- Titulo -->
                <div class="row mb-4">
                    <div class="col">
                        <div class="titulo-site white-text">Controle de Compras</div>
                    </div>
                </div>
                
                <!-- Navegacao -->
                <nav class="nav-footer d-flex justify-content-around flex-column flex-md-row">
                    <a class="text-center footer-nav-item" href="index.php">Home</a>
                    <?php
                        if (usuario_esta_logado()) {
                    ?>
                        <a class="text-center footer-nav-item" href="formulario-compra.php">Adicionar Compra</a>
                        <a class="text-center footer-nav-item" href="listar-compras.php">Compras</a>
                        <a class="text-center footer-nav-item" href="buscar.php">Buscar</a>
                        <?php
                            if (admin()) {
                        ?>
                            <a class="text-center footer-nav-item" href="requisicoes.php">Requisições</a>
                        <?php
                            }
                        ?>
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
        <script src="js/jquery-latest.js"></script>                                                                 <!-- JQuery -->
        <script src="js/jquery-ui.js"></script>                                                                     <!-- JQuery UI -->
        <script src="js/popper.min.js"></script>                                                                    <!-- Popper -->
        <script src="js/bootstrap.js"></script>                                                                     <!-- Boostrap -->
        <script src="js/mdb.js"></script>                                                                           <!-- MDBootstrap -->
        <script src="js/datatables.js"></script>                                                                    <!-- MDBootstrap / Datatables -->
        <script src="js/select2.js"></script>                                                                       <!-- Select2 -->
        <script src="js/jquery.mask.js"></script>                                                                   <!-- JQuery Masks -->
        <script src="js/bootstrap-confirmation.js"></script>                                                        <!-- Boostrap Confirmation -->
        <script src="js/cropper.js"></script>                                                                       <!-- Cropper -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>                <!-- Toastr -->
        <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>      <!-- Code Prettify -->
        <script src="js/code-prettify/lang-sql.js"></script>                                                        <!-- Code Prettify / SQL -->
        <script src="js/jquery.canvasjs.min.js"></script>                                                           <!-- JQuery Canvas -->

        <script src="js/main.js"></script>


    </body>

</html>