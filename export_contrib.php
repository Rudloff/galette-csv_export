<?php
/**
 * Export contributions with some tweaks
 * (like French number format)
 * 
 * PHP version 5.4.6
 * 
 * @category Plugin
 * @package  CSV_Export
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  LGPL https://www.gnu.org/copyleft/lesser.html
 * @link     https://www.gnu.org/copyleft/lesser.html
 * 
 * */
use Galette\IO\Csv;
use Galette\Filters\MembersList;
use Galette\Entity\FieldsConfig;
use Galette\Entity\Adherent;
use Galette\Repository\Members;

//définition de la constante obligatoire
define('GALETTE_BASE_PATH', '../../');
//inclusion du fichier principal de galette
require_once GALETTE_BASE_PATH . 'includes/galette.inc.php';
if ( $login->isAdmin() || $login->isStaff() ) {
    header('Content-Type: text/csv');
    header("Content-Disposition: attachment; filename=cotisations.csv"); 
    $csv = new Csv();
        
    $result = $zdb->db->query(
        str_replace(
            'galette_', PREFIX_DB,
            'SELECT nom_adh, prenom_adh, societe_adh, ville_adh, '.
            'montant_cotis, date_debut_cotis, date_fin_cotis FROM '.
            'galette_cotisations INNER JOIN galette_adherents ON '.
            '(galette_cotisations.id_adh=galette_adherents.id_adh)'
        )
    )->fetchAll(
        \Zend_Db::FETCH_ASSOC
    );


    $titles=array(
        _('Name'), _('Surname'), _('Society'), _('City'), _('Amount'),
        _('Begin date'), _('End date')
    );
    
    foreach ($result as &$line) {
        $line['montant_cotis']=str_replace('.', ',', $line['montant_cotis']);
    }
    $csv->export($result, $separator, $quote, $title);
    echo(
        $csv->export(
            $result, $csv->DEFAULT_SEPARATOR, $csv->DEFAULT_QUOTE, $titles
        )
    );
    
  
}
?>
