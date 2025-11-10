<?php session_start(); 
define('IN_APP', true);
require 'cnx/cnx_info.php';
include 'fonctions/fonction.php';
?>
<!DOCTYPE html>
<html data-bs-theme="dark">
    <head>
        <title>PJ PNJ JDR</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="images/LOGO-PJ.ico" rel="icon" type="image/x-icon">
        
        <!-- Compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../css/style.css">

        <!-- Compiled and minified JavaScript -->
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
        <script src="../jquery/jquery.js"></script>

    </head>

    <body class="dark-mode">
    

        



<div class="container mt-4"><!-- DEBUT CONTAINER GLOBAL -->

         <!-- LIGNE 1 -->
         <div class="row mb-2">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header background-elric">ELRIC</div>
                    <!-- <img src="../../images/ban_elric.png" class="img-fluid rounded-start me-2"> -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-dark">
                    <div class="card-header text-center">Allégeance</div>
                </div>
            </div>
        </div>

        <!-- LIGNE 2 -->
        <div class="row mb-2">
            <div class="col-md-9">
                <div class="card text-bg-dark">
                    <div class="card-header text-center">Nom du joueur</div>
                    <div class="card-body"><h5 class="card-title text-center">........................................</h5></div>
                </div>
            </div>
            <div class="col-md-1">
                <div class="card text-bg-dark">
                    <div class="card-header text-center px-2">Chaos</div>
                    <div class="card-body"><h5 class="card-title text-center">3</h5></div>
                </div>
            </div>
            <div class="col-md-1">
                <div class="card text-bg-dark">
                    <div class="card-header text-center px-2">Balance</div>
                    <div class="card-body"><h5 class="card-title text-center">4</h5></div>
                </div>
            </div>
            <div class="col-md-1">
                <div class="card text-bg-dark">
                    <div class="card-header text-center px-2">Loi</div>
                    <div class="card-body"><h5 class="card-title text-center">1</h5></div>
                </div>
            </div>
        </div>


        <!-- LIGNE 3 -->
        <div class="row mb-2">
            <div class="col-md-9">

                <div class="card text-bg-dark">
                    <div class="card-header text-center">Caractéristiques</div>
                        <div class="card-body">
                            <div class="row"> 
                                <!-- FOR,CON,etc -->
                                <div class="col-md-2">
                                    <table class="table table-striped-columns">
                                        <tr>
                                            <td class="col">FOR</td><td>18</td> <tr></tr>
                                            <td class="col">CON</td><td>14</td> <tr></tr>
                                            <td class="col">TAI</td><td>15</td> <tr></tr>
                                            <td class="col">INT</td><td>15</td> <tr></tr>
                                            <td class="col">POU</td><td>16</td> <tr></tr>
                                            <td class="col">DEX</td><td>13</td> <tr></tr>
                                            <td class="col">APP</td><td>14</td> <tr></tr>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-3">
                                    <table class="table table-striped-columns">
                                        <tr>
                                            <td>Modif. aux dégats</td><td>1D6+1</td> <tr></tr>
                                            <td>Taille</td><td>1,90m</td> <tr></tr>
                                            <td>Poids</td><td>95kg</td> <tr></tr>
                                            <td>Idée</td><td>42%</td> <tr></tr>
                                            <td>Chance</td><td>38%</td> <tr></tr>
                                            <td>Dextérité</td><td>45%</td> <tr></tr>
                                            <td>Charisme</td><td>55%</td> <tr></tr>
                                        </tr>
                                    </table>
                                </div>


                                <div class="col-md-7">
                                    <table class="table table-striped-columns">
                                        <tr>
                                            <td class="col">Nationalité</td> <td>Filkhar</td> <tr></tr>
                                            <td class="col">Sexe</td> <td>Masculin</td> <tr></tr>
                                            <td class="col">Age</td> <td>35 ans</td> <tr></tr>
                                        </tr>
                                    </table>
                                </div>
                                <!-- FIN FOR,CON,etc -->
                            </div>
                        </div>    
                    </div>
                </div>
   
            <div class="col-md-3">
                <div class="card text-bg-dark">
                    <div class="card-header text-center">Avatar</div>
                    <div class="card-body text-center"><img src="https://files.idyllic.app/files/static/2060132?width=640&optimizer=image" width="250" height="250" alt="Avatar"></div>
                    <div class="card-footer text-center"><h5>Nathaniel RAELITH</h5></div>
                </div>
                
            </div>
        </div>

</div><!-- FIN CONTAINER GLOBAL -->