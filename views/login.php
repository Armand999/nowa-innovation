<?php $title = 'Se Connecter à l\'administration du site'; ?>

<main id="main">
    <!-- Login section -->
    <section id="contact" class="contact" style="margin-top: 50px">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Se Connecter</h2>
                <p>Cet espace est dédié à l'administration du site</p>
            </div>

            <div class="row justify-content-center" data-aos="fade-up">
                <div class="col-lg-12">
                    <form action="<?= PATH_ORIGIN . 'admin/se-connecter' ?>" method="post" class="php-email-form">
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="username" class="form-control <?= isset($params['errors']['username']) ? 'is-invalid' : '' ?>" placeholder="Entrez votre ID de connexion" value="<?= isset($_POST['username']) ? htmlentities($_POST['username']) : '' ?>" required />
                                <?php if (isset($params['errors']['username'])) : ?>
                                    <div class="invalid-feedback">
                                        <?php foreach ($params['errors']['username'] as $err) : ?>
                                            <?php echo $err;
                                            break; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="password" class="form-control <?= isset($params['errors']['password']) ? 'is-invalid' : '' ?>" name="password" placeholder="Entrez votre mot de passe" required />
                                <?php if (isset($params['errors']['password'])) : ?>
                                    <div class="invalid-feedback">
                                        <?php foreach ($params['errors']['password'] as $err) : ?>
                                            <?php echo $err;
                                            break; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <button type="submit">Se Connecter</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section><!-- End Login Section -->
</main><!-- End #main -->