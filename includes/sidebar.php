<?php
    echo '<div class="main">
    <aside class="sidebar">
        <h1>
            Med<span><img src="../img/logo.svg" alt=" " /></span>ica
        </h1>
        <ul class="linksMet">
            <li>
                <a href="./acceuil.php"><i class="fas fa-home"></i> home</a>
            </li>
            <li>
                <a href="./ajouterPatients.php"><i class="fas fa-user-plus"></i> ajouter patient</a>
            </li>
            <li>
                <a href="./listepatients.php"><i class="fas fa-list"></i> liste des patients</a>
            </li>
            <li>
                <a href="../comptabilite/compta.php"><i class="fas fa-calculator"></i> comptabilite</a>
            </li>
        </ul>
        <div class="user-info">
            <div class="user">
                <img src="../img/receptionist.png" alt="user" />
                <p>secretaire</p>
            </div>
            <ul class="links">
                <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>logout</a></li>
                <li><a href="#"><i class="fas fa-key"></i>Reset</a></li>
            </ul>
        </div>
    </aside>';

    ?>