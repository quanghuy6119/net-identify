<?php
namespace App\Domain\Entities\User;

use JMS\Serializer\Annotation as Serializer;
use File;

trait AvatarProp{

    /**
     * Get the avatar of users
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("avatar")
     *
     * @return  string
     */ 
    public function getAvatar(): string {
        $extensions = ['jpeg', 'jpg', 'png'];
        foreach ($extensions as $extension) {
            $avatar = '/avatars/' . $this->id . "." . $extension;
            $fileName = public_path() . $avatar;
            $rs = File::exists($fileName);
            if ($rs) return env('APP_URL') . $avatar;
        }
        return env('APP_URL'). '/avatars/0.jpg';
    }
}