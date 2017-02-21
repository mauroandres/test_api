<?php
namespace App\Transformer;

use App\User;
use League\Fractal\TransformerAbstract;
use App\Helpers\EnvironmentHelper;

class UserTransformer extends TransformerAbstract
{
    /**
     * Transform a User model into an array
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'image' => EnvironmentHelper::host() . $user->image,
        ];
    }    
}