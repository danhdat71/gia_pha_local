<?php

namespace App\Http\Controllers;

use App\Constants\CurrentPage;
use App\Http\Controllers\Controller;
use App\Traits\FileTrait;

class FileController extends Controller
{
    use FileTrait;

    public function getCCCDImage($imageName)
    {
        return $this->getCCCD($imageName);
    }

    public function getAvatarImage($imageName)
    {
        return $this->getAvatar($imageName);
    }

    public function getProofImage($imageName)
    {
        return $this->getProof($imageName);
    }

    public function getRestImage($imageName)
    {
        return $this->getRestImg($imageName);
    }

    public function getCertImage($imageName)
    {
        return $this->getCertImg($imageName);
    }

    public function getBlogImage($imageName)
    {
        return $this->getBlogAvatar($imageName);
    }

    public function get360Video($videoName)
    {
        return $this->get360VideoReview($videoName);
    }

    public function getVr3D($fileName)
    {
        return $this->getVr3DReview($fileName);
    }
}
