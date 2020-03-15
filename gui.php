<?php
try{
    $base = new PDO("mysql:host=localhost", "root", "");
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   try 
   { $base->exec("CREATE DATABASE pfa");}
   catch(PDOException $e)
   {echo "";}
   $base->exec("use pfa;");
   
}
catch(PDOException $e)
{
echo "";
} 
if(!(isset($_POST['idd']) && isset($_POST['pass']))&& isset($_POST['conn']))
{
    
    echo "<script type=\"text/javascript\">alert(\"*Identifiant ou Mot de passe incorrecte(s)\");</script>";header("Refresh:0; url=login1.php");
}
else
{
    $i=&$_POST['idd'];
    $p=&$_POST['pass'];
    global $i,$p;
    function exist($i,$p)
    {
        global $base;
        $ch=$base->query("SELECT idg,pass FROM guichetier ORDER BY idg;");
        foreach($ch as $row)
        {
            if ($row['idg']==$i && $row['pass']==$p)
            {return 1;}
        }
        return 0;
    }
    if (exist($i,$p)==0 && isset($_POST['conn']))
    {echo "<script type=\"text/javascript\">alert(\"*Identifiant ou Mot de passe incorrecte(s)\");</script>";header("Refresh:0; url=login1.php");}
}
    $ch=$base->query("SELECT nom,prenom,Nom_banque FROM guichetier where pass='$p' and idg='$i' ORDER BY idg;");
    $s=$base->query("INSERT INTO transcrire (idg)VALUE('$i'); ")
    ?>
 <html>
    <head>
        <title>Espace Guichetier</title>
        <style>
            body
            {
                margin-left: 0%;
                margin-top:0%;
                margin-right: 0%;
                margin-bottom: 0%;
                background-image: url(bb.png);
                height: 100%;
            }
            #fdiv
            {
              
                background-image: url(b1.png);
                padding-top: 0px;
                margin-left: 0;
                margin-bottom: 0px;
                margin-right: 0px;
                height: 100%;
                border-left: 5px;
            }
            #droite
            {
                border-left:solid #03769c;
                border-top-left-radius: 60px;
                border-bottom-left-radius: 60px;
                width: 50%;
                height: 100%;
                text-align: center;
                float: right;
            }
            #gauche
            {
                width: 45%;
                float: left;
            }
            #tit
            {
                margin-top: 0%;
                margin-bottom: 0%;
                color:#0b5872;
            }
            #tit2
            {
                /*margin-top: 5%;*/
                /*margin-bottom: 5%;*/
                padding-top: 20px;
                color:#0b5872;
            }
            .barr
            {
                opacity: 0.7;
                border-radius: 9px;
                width:50%;
                height: 25px;
            }
            #button 
            {
                background-color:cadetblue;
                font-size: larger;
                text-align : center;
                color : white ;
                border : none;
                border-radius: 7px;
                opacity: 1;
                transition-duration: 0.4s;
            }
            #button:hover 
            {
                background-color: rgb(115, 204, 118);
                color: white;
                cursor: pointer;
            }
            form
            {
                text-align: center;
                padding-top: 35px;
            }
        </style>
    </head>

    <body>
        <div style="background-color:#1c1a66;height:40px;opacity:0.8;">
            <h2 style="margin-bottom:0px;">Deconnexion</h2>
        </div>
        <div id=fdiv>
        <div id=gauche style="text-align:center;">
                <?php
                 foreach($ch as $row)
                 {      echo"<h2 id=tit>";
                     echo "Nom: ".$row['nom']."</br> ";
                     echo "Prenom: ".$row['prenom']."</br> ";
                     echo "Banque: ".$row['Nom_banque']."</br> ";
                     echo "</h2>";
                 }
                ?>
                <form method=POST>
                    <label for=rech><h1 id=tit>Tapez Le numrero du CIN</h1></label></br>
                    <input type=number class=barr id=rech name=ci placeholder=exp:12345678 autocomplete=off>
                    <input type="hidden" id="custId" name="custId" value="<?php echo"".$i."".$p.""; ?> ">
                    <input type=submit id=button value=Rechercher>
                </form>
            </div>
            <div id=droite>
                <h1 id=tit2>Infos du Passager</h1>
                <?php
                if(isset($_POST['ci']))
                {
                    function existc($c)
                    {
                        global $base;
                        $ch=$base->query("SELECT cin FROM client;");
                        foreach($ch as $row)
                        {
                            if ($row['cin']==$c)
                            {return 1;}
                        }
                        return 0;
                    }
                    $c=$_POST['ci'];
                    $h=$base->query("SELECT * FROM client;");
                    if(existc($c)==1)
                    {
                        foreach($h as $row)
                        {      echo"<h2 id=tit>";
                            echo "Nom: ".$row['nom']."</br> ";
                            echo "Prenom: ".$row['prenom']."</br> ";
                            echo "Quota Disponilbe: ".$row['quota_dispo']."</br> ";
                            echo "</h2>";
                        }  
                        print_r($i); 
                        echo "<form method=POST>
                        <label for=rech><h1 id=tit>Effectuer la transaction</h1></label></br>
                        <input type=number class=barr id=rech name=m placeholder=\"Entrer la somme à transcrire\" autocomplete=off>
                        <input type=submit id=button value=Transcrire name=tr>
                    </form>";
                    
                    if(isset($_POST['tr']) && isset($_POST['m']))
                    {
                        $a=$_POST['m'];

                    }

                    }
                }
                ?>
            </div>
            
        </div>
    </body>
</html>
