<?php

include_once(__DIR__ . '/../includes/mongo.php');


class UserModel extends BaseModel {
    protected $collection = 'users';
}
