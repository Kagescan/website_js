<?php

namespace App\Models;

/**
 * ArticleModel
 *
 * @author  LoganTann
 * @package App\Models
 * @since   1.99
 */
use CodeIgniter\Model;

/**
 *
 */
class ArticleModel extends Model
{
  protected $table = "articles";
    /**
     * @param slug the slug (aka. "clean url") of the article
     */
    public function getArticles($slug = false)
    {
        if ($slug === false) {
          return $this->findAll();
        }

        return $this->asArray()
                    ->where(['slug'=>$slug])
                    ->first();
    }

    //--------------------------------------------------------------------

}


/* End of file ArticleModel.php */
