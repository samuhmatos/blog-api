<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="widget">
                    <div class="footer-text text-left">
                        <a href="/"><img src="/assets/img/logo/tech-footer-logo.png" alt="" class="img-fluid"></a>
                        <p>Este é um blog simulando postagens de varios segmentos e entregando ao usuario</p>
                        <div class="social" style="display: flex;">
                            <a class="nav-link" data-placement="bottom" href="https://www.instagram.com/samuh.matos/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                            <a class="nav-link" data-placement="bottom" href="https://www.linkedin.com/in/o-samuelmatos/" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                            <a class="nav-link" href="mailto:samuhmatos@gmail.com" data-placement="bottom"><i class="fa-regular fa-envelope" target="_blank"></i></a>
                            <a class="nav-link" href="https://github.com/samuhmatos" target="_blank" data-placement="bottom"><i class="fa-brands fa-github"></i></a>
                        </div>

                        <hr class="invis">

                        <div class="newsletter-widget text-left">
                            <form class="form-inline form_getEmail" id="saveContact">
                                <input type="email" class="form-control" placeholder="Gostou do projeto? Deixe seu email" id="saveContact_email" required>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </form>
                        </div><!-- end newsletter -->
                    </div><!-- end footer-text -->
                </div><!-- end widget -->
            </div><!-- end col -->

            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <div class="widget">
                    <h2 class="widget-title">Categorias Populares</h2>
                    <div class="link-widget">
                        <ul>
                            <?php
                                foreach ($args['popularCategories'] as $key => $value) {
                            ?>
                            <li>
                                <a href="/category/<?=$value['category']?>">
                                    <?=ucfirst($value['category'])?>
                                    <span>(<?=ucfirst($value['amount'])?>)</span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div><!-- end link-widget -->
                </div><!-- end widget -->
            </div><!-- end col -->

            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                <div class="widget">
                    <h2 class="widget-title">Copyrights</h2>
                    <div class="link-widget">
                        <ul>
                            <li><a href="/contact">Entre em contato</a></li>
                            <li><a href="/contact">Tem sugestão?</a></li>
                        </ul>
                    </div><!-- end link-widget -->
                </div><!-- end widget -->
            </div><!-- end col -->
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <br>
                <div class="copyright">&copy; Blog. Desenvolvedor: <a href="/contact">Samuel Matos</a>.</div>
            </div>
        </div>
    </div><!-- end container -->
</footer><!-- end footer -->
</div>

<script src="/assets/js/universal.js"></script>

</body>
</html>
