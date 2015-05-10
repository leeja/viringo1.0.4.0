<?PHP
/**
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 */

/**
 * @see class PHPMailer  5.1
 * @link http://phpmailer.sourceforge.net
 */
require_once ('phpMailer5.1' . DIRECTORY_SEPARATOR .'class.phpmailer.php');

/**
 * Funciones para envio de Correos.
 *
 * @package viringo1.0.1.0
 * @author Soporte <soporte@jasoftsolutions.com>
 * @copyright 2012 - JASoft Solutions E.I.R.L.
 * @version 1.0.1.0  26/02/2012
 * @access public
 */
class Class_Mail extends PHPMailer 
{

   

    /**
     * Clase constructora, inicializa variables.<br>
     * Ej: Host = 10.2.0.12
     * 
     * @return void
     */
    public function __construct()
    {
        //$this->_ObjPhpMailer = new PHPMailer();
        //$this->IsSMTP(); // telling the class to use SMTP
        //$this->Host = "mail.jasoftsolutions.com"; // SMTP server
	 $this->PluginDir = 'phpMailer5.1' . DIRECTORY_SEPARATOR;
    }

    /**
     * Envia un email usando la función mail de PHP.
     * 
     * <b>[algoritmo]</b><br>
     * Verifica si $config['configurationMailServer'] === 1;
     * 
     * @param string $to Destinatarios
     * @param string $subject Asunto
     * @param string $message Mensaje
     * @param string $headers Cabecera
     * @return bool
     */
    public function sendMail($to, $subject, $message, $headers)
    {

        if (Class_Config::get('configurationMailServer') === 1) {

            $tempMail = @mail($to, $subject, $message, $headers);
            if (!($tempMail)) {
                Class_Error::messageError( 'Mail Server not setting' );
            } else
                return true;
        } else
            Class_Error::messageError( 'Mail Server no found in this Server, modify $config[configurationMailServer]' );
        return false;

    }

    /**
     * Envia un email usando la función Send de PHPMailer, con el protocolo SMTP.
     * 
     * @param string $to Destinatarios, para multiples destinatarios use ';'
     * @param string $subject Asunto
     * @param string $message Mensaje
     * @param string $loginFrom defecto 'otlinformatica'
     * @return bool
     */
    public function sendSmtp($to, $subject, $message, $loginFrom = 'otlinformatica')
    {
        $objMaster = new Class_Master();
        $objUser = $objMaster->getDataUser($loginFrom);

        if (isset($objUser)) {
            $this->From = $objUser->getEmail();
            $this->FromName = $objUser->getName() . " " . $objUser->
                getFirstLastName() . " " . $objUser->getSecondLastName();
        } else
            return false;

        $this->Subject = $subject;

        $this->MsgHTML($message);

        $arrayEmail = explode(';', $to);

        if (is_array($arrayEmail)) {
            foreach ($arrayEmail as $key => $value) {
                $this->AddAddress($value);
            }
        }

        if (!$this->Send()) {
            Class_Error::messageError("Error: " . $this->ErrorInfo);
            return false;
        } else {
            return true;
        }

    }

}
