    
    <div class="form_body">
    <form action="<?= PATH_ORIGIN . 'contact' ?>" method="post" class="php-email-form">
        <div class="form_container">
            <div class="form_top">
                <div>
                    <h2>
                        Des questions ? N'hésitez pas à nous contacter !
                    </h2>
                </div>
            </div>
            <div class="form_wrap">
            
                <div class="form_informations">
                    <div class="info_top">
                        <div>
                            <p>Nom</p>
                            <input type="text" name="lastname" placeholder="Nom" autocomplete="off" class="<?= isset($params['errors']['lastname']) ? 'is-invalid' : '' ?>"  required />
                            <?php if (isset($params['errors']['lastname'])) : ?>
                                    <div class="invalid-feedback">
                                        <?php foreach ($params['errors']['lastname'] as $err) : ?>
                                            <?php echo $err;
                                            break; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                        </div>
                        <div>
                            <p>Prénom</p>
                            <input type="text" placeholder="Prénom" autocomplete="off" class="<?= isset($params['errors']['firstname']) ? 'is-invalid' : '' ?>" name="firstname" required />
                        </div>
                    </div>
                    <div class="info_top">
                        <div>
                            <p>Email</p>
                            <input type="text" placeholder="monemail@email.com" autocomplete="off" class="<?= isset($params['errors']['email']) ? 'is-invalid' : '' ?>" name="email"  required />
							<?php if (isset($params['errors']['email'])) : ?>
                                <div class="invalid-feedback">
                                    <?php foreach ($params['errors']['email'] as $err) : ?>
                                        <?php echo $err;
                                        break; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <p>Numéro de téléphone<span>(facultatif)</span></p>
                            <input type="text" placeholder="0601020304" autocomplete="off" class="<?= isset($params['errors']['tel']) ? 'is-invalid' : '' ?>" name="tel" >

                        </div>
                    </div>
                    <div class="info_bottom">
                        <div>
                            <p>Message</p>
                            <textarea name="message" cols="300" rows="10" autocomplete="off" class="<?= isset($params['errors']['message']) ? 'is-invalid' : '' ?>" ></textarea>
                        </div>
                    </div>
                </div>
                 
            </div>
            <div class="form_button">
                <a href="#">
                    <p>
                       <button type="submit">Soumettre</button>
                    </p>
                </a>
            </div>
        </div>
        </form>
        <div class="form_logo">
            <img src="<?= SCRIPTS . 'img' . DIRECTORY_SEPARATOR . 'Logo noir & orange.svg' ?>" alt="logo">
        </div>
        
    </div>
