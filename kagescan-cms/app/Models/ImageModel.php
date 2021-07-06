<?php

namespace App\Models;

/**
 * ImageModel
 * @author  LoganTann
 * @package App\Models
 * @since   1.99
 */
use CodeIgniter\Model;

/**
 *
 */
class ImageModel extends Model
{
    /*
     * CREATE TABLE `kagescan`.`images` (
     * `field_id` INT NOT NULL AUTO_INCREMENT COMMENT 'The SQL row identifier; ie. primary key' ,
     * `image_id` TINYTEXT NOT NULL COMMENT 'The image\'s identifier, or slug.' ,
     * `real_filename` TINYTEXT NOT NULL COMMENT 'The filename of the stored image. Can also be a special predefined action such as a redirection or an error image.' ,
     * `alt` TINYTEXT NOT NULL DEFAULT '' COMMENT 'The alt attribute of the image. If empty, the attribute is not added' ,
     * `description` TEXT NOT NULL DEFAULT '' COMMENT 'Describes what this image is used for' ,
     * `upload_comment` TINYTEXT NOT NULL DEFAULT '' COMMENT 'A short text used for the history message' ,
     * `created_at` DATE NOT NULL COMMENT 'Holds the date of upload.' ,
     * `updated_at` INT NULL COMMENT 'Hold the latest date of description update.' ,
     * `deleted_at` INT NULL COMMENT 'If not null/empty, means that this file is currently deleted or have been edited.',
     * PRIMARY KEY (`field_id`)
     * ) ENGINE = InnoDB;
     */

    protected $table = "images";
    protected $allowedFields = ["image_id", "real_filename", "alt", "description", "upload_comment"];
    protected $primaryKey = 'field_id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $deletedField  = 'deleted_at';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // TODO : protected $validationRules    = [];
    // TODO : protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Given an image name, returns it's filename and metadata
     * @param string $name : the image identifier
     * @param bool $completeInformations :
     */
    public function getImage($name, $completeInformations = false)
    {
        // TODO : gestion des mots clés spéciaux : >erreurs (traitées par le contrôleur) et >redirections (traitées ici)
        // redirections -> pas la priorité car je pense pas que ça sera très utilisé

        return $this->asArray()
            ->where(['real_filename'=>$name]) // + implicit deleted = 0
            ->first();
        // return filename approprié et alt. Le contrôleur se chargera de déterminer le type mime de l'image.
    }

    // create -> save([])

    public function deleteImage($name) {

    }

    /**
     * Renames all images that holds the identifier currentName to newName
     * @param $currentName
     * @param $newName
     */
    public function renameImage($currentName, $newName) {

    }

    public function updateDescription($name, $description) {

    }

    public function updateAlt($name, $alt) {

    }


    //--------------------------------------------------------------------

}


/* End of file ArticleModel.php */
