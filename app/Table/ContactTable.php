<?php

namespace App\Table;

use Core\Table\AbstractTable;
use Core\Validator\Validator;
use PHPMailer\PHPMailer\PHPMailer;

class ContactTable extends AbstractTable
{
    /**
     * Database Table
     *
     * @var string $table
     */
    protected $table;

    /**
     * Get last Contacts 
     *
     * @return void
     */
    public function getLastContacts()
    {
        return $this->db->query(
            'SELECT * FROM ' . $this->table . ' ORDER BY id DESC',
            str_replace('Table', 'Entity', get_class($this))
        );
    }

    /**
     * Send A Reclamation by Email
     *
     */
    public function sendContactByEmail()
    {
        $logoPath = 'http://localhost/nowa-innov/public\assets\img\Logo noir & orange.svg';

        if (!empty($_POST)) {

            $lastname  = htmlspecialchars($_POST['lastname']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $email     = htmlspecialchars($_POST['email']);	
            $tel       = htmlspecialchars($_POST['tel']);
            $messageText   = htmlspecialchars($_POST['message']);


            $mailer = new PHPMailer();

            $mailer->CharSet = "utf-8";
            $mailer->setFrom("no-reply@nowa-innovation.com");

            $mailer->addAddress('contact@nowa-innovation.com');
            $mailer->isHTML();
            $mailer->Body    = '<head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title></title>
            <style type="text/css">
                /* ----- Custom Font Import ----- */
                @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i);
        
                /* ----- Text Styles ----- */
                table {
                    font-family: "Open Sans", Arial, sans-serif;
                    -webkit-font-smoothing: antialiased;
                    -moz-font-smoothing: antialiased;
                }
        
                @media only screen and (max-width: 700px) {
        
                    /* ----- Base styles ----- */
                    .full-width-container {
                        padding: 0 !important;
                    }
        
                    .container {
                        width: 100% !important;
                    }
        
                    /* ----- Header ----- */
                    .header td {
                        padding: 30px 15px 30px 15px !important;
                    }
        
                    /* ----- Hero subheader ----- */
                    .hero-subheader__title {
                        padding: 80px 15px 15px 15px !important;
                        font-size: 35px !important;
                    }
        
                    .hero-subheader__content {
                        padding: 0 15px 90px 15px !important;
                    }
        
                    /* ----- Title block ----- */
                    .title-block {
                        padding: 0 15px 0 15px;
                    }
        
                    /* ----- Paragraph block ----- */
                    .paragraph-block__content {
                        padding: 25px 15px 18px 15px !important;
                    }
                }
            </style>
        </head>
        
        <body style="padding: 0; margin: 0; background-color: #eeeeee;">
        
            <!-- / Full width container -->
            <table class="full-width-container" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"
                bgcolor="#eeeeee" style="width: 100%; height: 100%; padding: 30px 0 30px 0;">
                <tr>
                    <td align="center" valign="top">
                        <!-- / 700px container -->
                        <table class="container" border="0" cellpadding="0" cellspacing="0" width="700" bgcolor="#ffffff"
                            style="width: 700px;">
                            <tr>
                                <td align="center" valign="top">
                                    <!-- / Header -->
                                    <table class="container header" border="0" cellpadding="0" cellspacing="0" width="620"
                                        style="width: 620px;">
                                        <tr>
                                            <td style="padding: 30px 0 30px 0; border-bottom: solid 1px #eeeeee;" align="left">
                                                <a href="#">
                                                    <img src="http://localhost/nowa-innov/public\assets\img\Logo noir & orange.svg"
                                                    alt="Logo Orisse" class="img-fluid">
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- /// Header -->
        
                                    <!-- / Hero subheader -->
                                    <table class="container hero-subheader" border="0" cellpadding="0" cellspacing="0"
                                        width="620" style="width: 620px;">
                                        <tr>
                                            <td class="hero-subheader__title"
                                                style="font-size: 35px; font-weight: bold; padding: 40px 0 15px 0;"
                                                align="left">' . $object . '</td>
                                        </tr>
        
                                        <tr>
                                            <td class="hero-subheader__content"
                                                style="font-size: 16px; line-height: 27px; color: #969696; padding: 0 60px 30px 0;"
                                                align="left">
                                                Vous avez reçu une nouvelle demande de contact. <br><br>
                                                Les différentes informations du client sont: <br>
                                                Nom : ' . $lastname . ' <br>
                                                Prénoms : ' . $firstname . ' <br>
                                                Email : ' . $email . ' <br>
                                                Tél : ' . $area_code . ' ' . $tel . ' <br><br>' .
                $messageText . '
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- /// Hero subheader -->
        
                                    <!-- / Divider -->
                                    <table class="container" border="0" cellpadding="0" cellspacing="0" width="100%"
                                        style="padding-top: 25px;" align="center">
                                        <tr>
                                            <td align="center">
                                                <table class="container" border="0" cellpadding="0" cellspacing="0" width="620"
                                                    align="center" style="border-bottom: solid 1px #eeeeee; width: 620px;">
                                                    <tr>
                                                        <td align="center">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- /// Divider -->
        
                                    <!-- / Footer -->
                                    <table class="container" border="0" cellpadding="0" cellspacing="0" width="100%"
                                        align="center">
                                        <tr>
                                            <td align="center">
                                                <table class="container" border="0" cellpadding="0" cellspacing="0" width="620"
                                                    align="center" style="border-top: 1px solid #eeeeee; width: 620px;">
                                                    <tr>
                                                        <td style="text-align: center; padding: 50px 0 10px 0;">
                                                            <a href="#"
                                                                style="font-size: 28px; text-decoration: none; color: #d5d5d5;">Oriss
                                                                Energy</a>
                                                        </td>
                                                    </tr>
        
                                                    <tr>
                                                        <td
                                                            style="color: #d5d5d5; text-align: center; font-size: 15px; padding: 10px 0 60px 0; line-height: 22px;">
                                                            Copyright &copy; 2021 <a href="" target="_blank"
                                                                style="text-decoration: none; border-bottom: 1px solid #d5d5d5; color: #d5d5d5;">Oriss
                                                                Energy</a>.
                                                            <br />Tous droits réservés.
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- /// Footer -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>';
            $mailer->AltBody = '<head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title></title>
            <style type="text/css">
                /* ----- Custom Font Import ----- */
                @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i);
        
                /* ----- Text Styles ----- */
                table {
                    font-family: "Open Sans", Arial, sans-serif;
                    -webkit-font-smoothing: antialiased;
                    -moz-font-smoothing: antialiased;
                }
        
                @media only screen and (max-width: 700px) {
        
                    /* ----- Base styles ----- */
                    .full-width-container {
                        padding: 0 !important;
                    }
        
                    .container {
                        width: 100% !important;
                    }
        
                    /* ----- Header ----- */
                    .header td {
                        padding: 30px 15px 30px 15px !important;
                    }
        
                    /* ----- Hero subheader ----- */
                    .hero-subheader__title {
                        padding: 80px 15px 15px 15px !important;
                        font-size: 35px !important;
                    }
        
                    .hero-subheader__content {
                        padding: 0 15px 90px 15px !important;
                    }
        
                    /* ----- Title block ----- */
                    .title-block {
                        padding: 0 15px 0 15px;
                    }
        
                    /* ----- Paragraph block ----- */
                    .paragraph-block__content {
                        padding: 25px 15px 18px 15px !important;
                    }
                }
            </style>
        </head>
        
        <body style="padding: 0; margin: 0; background-color: #eeeeee;">
        
            <!-- / Full width container -->
            <table class="full-width-container" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"
                bgcolor="#eeeeee" style="width: 100%; height: 100%; padding: 30px 0 30px 0;">
                <tr>
                    <td align="center" valign="top">
                        <!-- / 700px container -->
                        <table class="container" border="0" cellpadding="0" cellspacing="0" width="700" bgcolor="#ffffff"
                            style="width: 700px;">
                            <tr>
                                <td align="center" valign="top">
                                    <!-- / Header -->
                                    <table class="container header" border="0" cellpadding="0" cellspacing="0" width="620"
                                        style="width: 620px;">
                                        <tr>
                                            <td style="padding: 30px 0 30px 0; border-bottom: solid 1px #eeeeee;" align="left">
                                            <a href="" >
                                                <img src="" alt="" class="img-fluid"
                                            </a>
                                        </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- /// Header -->
        
                                    <!-- / Hero subheader -->
                                    <table class="container hero-subheader" border="0" cellpadding="0" cellspacing="0"
                                        width="620" style="width: 620px;">
                                        <tr>
                                            <td class="hero-subheader__title"
                                                style="font-size: 35px; font-weight: bold; padding: 40px 0 15px 0;"
                                                align="left">Nouvelle Réclamation client : ' . $object . '</td>
                                        </tr>
        
                                        <tr>
                                            <td class="hero-subheader__content"
                                                style="font-size: 16px; line-height: 27px; color: #969696; padding: 0 60px 90px 0;"
                                                align="left">
                                                Vous avez reçu un nouveau d\'un client. <br><br>
                                                Les différentes informations du client sont: <br>
                                                Nom : ' . $lastname . ' <br>
                                                Prénoms : ' . $firstname . ' <br>
                                                Email : ' . $email . ' <br>
                                                Tél :  ' . $tel . ' <br><br>' .
                $messageText . '
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- /// Hero subheader -->
        
                                    <!-- / Divider -->
                                    <table class="container" border="0" cellpadding="0" cellspacing="0" width="100%"
                                        style="padding-top: 25px;" align="center">
                                        <tr>
                                            <td align="center">
                                                <table class="container" border="0" cellpadding="0" cellspacing="0" width="620"
                                                    align="center" style="border-bottom: solid 1px #eeeeee; width: 620px;">
                                                    <tr>
                                                        <td align="center">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- /// Divider -->
        
                                    <!-- / Footer -->
                                    <table class="container" border="0" cellpadding="0" cellspacing="0" width="100%"
                                        align="center">
                                        <tr>
                                            <td align="center">
                                                <table class="container" border="0" cellpadding="0" cellspacing="0" width="620"
                                                    align="center" style="border-top: 1px solid #eeeeee; width: 620px;">
                                                    <tr>
                                                        <td style="text-align: center; padding: 50px 0 10px 0;">
                                                            <a href="#"
                                                                style="font-size: 28px; text-decoration: none; color: #d5d5d5;">Oriss
                                                                Energy</a>
                                                        </td>
                                                    </tr>
        
                                                    <tr>
                                                        <td
                                                            style="color: #d5d5d5; text-align: center; font-size: 15px; padding: 10px 0 60px 0; line-height: 22px;">
                                                            Copyright &copy; 2021 <a href="" target="_blank"
                                                                style="text-decoration: none; border-bottom: 1px solid #d5d5d5; color: #d5d5d5;">Oriss
                                                                Energy</a>.
                                                            <br />Tous droits réservés.
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- /// Footer -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>';

            $mailer->send();
        }
    }


    /**
     * Insert a contact entry in Contact Table
     * 
     * @param Validator $validator
     */
    public function addContact(Validator $validator)
    {
        if (!empty($_POST)) {
            $errors = $validator->isValid([
                'lastname'  => ['notBlank'],
                'firstname' => ['notBlank'],
                'email'     => ['notBlank', 'notMail'],
                'tel'       => ['notBlank', 'notTel'],
                'message'   => ['notBlank']
            ]);
            
            if ($errors) return $errors;
            $query = $this->db->prepare(
                "SELECT * FROM $this->table WHERE email = ?",
                [htmlspecialchars(trim($_POST['email'], ' '))],
                str_replace('Table', 'Entity', get_class($this)),
                true
             
            );
           
            if ($query) return 'Cet email existe déjà';

            return $this->db->prepare(
                "INSERT INTO $this->table (lastname, firstname, email, tel, message) VALUES (:lastname, :firstname, :email, :tel, :message)",
                [
                    'lastname'  => htmlspecialchars($_POST['lastname']),
                    'firstname' => htmlspecialchars($_POST['firstname']),
                    'email'     => htmlspecialchars($_POST['email']),
                    'tel'       => htmlspecialchars($_POST['tel']),
                    'message'   => htmlspecialchars($_POST['message'])
                ]
            );
        }
    }
}
