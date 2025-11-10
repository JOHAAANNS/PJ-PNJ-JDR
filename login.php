<?php
if (isset($_SESSION['user_id'])) {
    header("Location: /?p=dashboard");
    exit;
}
?>


<div class="container-fluid px-0 mb-5">
       <div class="card">
        <div class="row g-0">
            <!-- Colonne image (gauche) -->
            <div class="col-md-6 d-flex">
                <img src="../images/img-login.jpeg" class="img-fluid w-100 h-100 object-fit-cover" alt="Connexion/Enregistrer">
            </div>
            

            <?php
            if (isset($_GET['mrg'])) 
            {
            ?>
            <div class="col-md-6">
                <form id="loginResetPwdForm" method="post">
                    <div class="card-body p-2">
                        <h3 class="card-title text-center mb-4">Réinitialisation du mot de passe</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" 
                                        title="Le mot de passe doit contenir au moins 8 caractères, dont une majuscule, un chiffre et un caractère spécial (!@#$%^&*()_+)."
                                        required>
                                <div class="form-text">
                                    <small>Doit contenir au moins : 
                                        <span id="uppercase" class="text-danger">1 majuscule</span>, 
                                        <span id="number" class="text-danger">1 chiffre</span>, 
                                        <span id="special" class="text-danger">1 caractère spécial</span>, 
                                        <span id="length" class="text-danger">8 caractères minimum</span>
                                    </small>
                                </div>
                            </li>
                            <li class="list-group-item"><label for="password2" class="form-label">Confirmation</label>
                                    <input type="password" class="form-control" id="password2" name="password2" required>
                                    <div id="passwordMatch" class="invalid-feedback">Les mots de passe ne correspondent pas</div></li>
                            <li class="list-group-item">
                                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                <input type="hidden" name="csrf_token_register" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <button type="submit" class="btn btn-primary w-100">Modifier son mot de passe</button>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>

            <?php
            }
            else
            {
            ?>






            <!-- Colonne formulaires (droite) -->
            <div class="col-md-6">
                <div class="row g-0">
                    <!-- Formulaire Connexion -->
                    <div class="col-md-6 p-3">
                        <div class="card-body p-2">
                            <h3 class="card-title text-center mb-4">Connexion</h3>
                            <form id="loginForm" method="post">
                                <div class="mb-3">
                                    <label for="mail-login" class="form-label">Mail</label>
                                    <input type="text" class="form-control" id="mail-login" name="mail-login" required>
                                    <div class="invalid-feedback">Veuillez entrer une adresse email valide</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password-login" class="form-label">Mot de passe</label>
                                    <input type="password" class="form-control" id="password-login" name="password-login" required>
                                    <div class="invalid-feedback">Le mot de passe doit contenir au moins 8 caractères</div>
                                </div>
                                <input type="hidden" name="csrf_token_login" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Formulaire Mot de passe oublié -->
                    <div class="col-md-6 p-3">
                        <div class="card-body p-2">
                            <h3 class="card-title text-center mb-4">Mot de passe perdu</h3>
                            <form id="LostMailForm" method="post">
                                <div class="mb-3">
                                    <label for="mail-login-lost" class="form-label">Mail</label>
                                    <input type="text" class="form-control" id="mail-login-lost" name="mail-login-lost" required>
                                    <div class="invalid-feedback">Veuillez entrer une adresse email valide</div>
                                </div>
                                
                                <input type="hidden" name="csrf_token_lost" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                <button type="submit" class="btn btn-primary w-100">Vérifier</button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Formulaire Inscription -->
                <div class="p-3">
                    <div class="card-body p-2">
                        <h3 class="card-title text-center mb-4">S'enregistrer</h3>
                        <form id="registerForm" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="mail" class="form-label">Mail</label>
                                <input type="text" class="form-control" id="mail" name="mail" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" 
                                    title="Le mot de passe doit contenir au moins 8 caractères, dont une majuscule, un chiffre et un caractère spécial (!@#$%^&*()_+)."
                                    required>
                                <div class="form-text">
                                    <small>Doit contenir au moins : 
                                        <span id="uppercase" class="text-danger">1 majuscule</span>, 
                                        <span id="number" class="text-danger">1 chiffre</span>, 
                                        <span id="special" class="text-danger">1 caractère spécial</span>, 
                                        <span id="length" class="text-danger">8 caractères minimum</span>
                                    </small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password2" class="form-label">Confirmation</label>
                                <input type="password" class="form-control" id="password2" name="password2" required>
                                <div id="passwordMatch" class="invalid-feedback">Les mots de passe ne correspondent pas</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="captcha" class="form-label">Captcha</label>
                                <div class="input-group">
                                    <img id="captchaImage" src="../requete/captcha.php" alt="CAPTCHA" style="height:70px;">
                                    <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Code" required style="width: 100px;">
                                    <button class="btn btn-outline-secondary" type="button" id="refreshCaptcha">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <input type="hidden" name="csrf_token_register" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>