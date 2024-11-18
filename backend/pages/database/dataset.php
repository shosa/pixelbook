<?php
$versione = '04/11/2024';
$desiredStructure = [
    'categorie' => [
        'columns' => [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'nome' => 'varchar(255) DEFAULT NULL',
            'descrizione' => 'text DEFAULT NULL',
            'banner' => 'varchar(255) DEFAULT NULL',
            'base_price' => 'float DEFAULT NULL',
            'type' => "varchar(255) NOT NULL DEFAULT 'personal'"
        ],
        'primary_key' => 'id',
    ],
    'galleria' => [
        'columns' => [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'categoria_id' => 'int(11) DEFAULT NULL',
            'file' => 'varchar(255) DEFAULT NULL'
        ],
        'primary_key' => 'id',
        'foreign_keys' => [
            'categoria_id' => ['table' => 'categorie', 'column' => 'id']
        ]
    ],
    'home_carousel' => [
        'columns' => [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'nome' => 'varchar(255) NOT NULL',
            'foto_blur' => 'varchar(255) NOT NULL',
            'foto' => 'varchar(255) NOT NULL',
            'tipo' => "enum('BUSINESS','PERSONAL') NOT NULL"
        ],
        'primary_key' => 'id'
    ],
    'prenotazioni' => [
        'columns' => [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'first_name' => 'varchar(255) DEFAULT NULL',
            'last_name' => 'varchar(255) NOT NULL',
            'mail' => 'varchar(255) DEFAULT NULL',
            'phone' => 'varchar(255) DEFAULT NULL',
            'date_of_submit' => 'date DEFAULT NULL',
            'category_id' => 'int(11) DEFAULT NULL',
            'service' => 'varchar(255) NOT NULL',
            'time_of_day' => 'varchar(255) NOT NULL',
            'duration' => 'varchar(255) NOT NULL',
            'date' => 'date NOT NULL',
            'flexible_date' => 'tinyint(1) NOT NULL',
            'note' => 'text DEFAULT NULL',
            'price' => 'float NOT NULL',
            'confirmed' => 'tinyint(1) NOT NULL DEFAULT 0',
            'adminNote' => 'text DEFAULT NULL'
        ],
        'primary_key' => 'id',
        'foreign_keys' => [
            'category_id' => ['table' => 'categorie', 'column' => 'id']
        ]
    ],
    'tariffario' => [
        'columns' => [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'Photo' => 'float NOT NULL',
            'Video' => 'float NOT NULL',
            'Photo & Video' => 'float NOT NULL',
            '1' => 'float NOT NULL',
            '2' => 'float NOT NULL',
            '3' => 'float NOT NULL',
            'Custom' => 'float NOT NULL'
        ],
        'primary_key' => 'id'
    ],
    'users' => [
        'columns' => [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'email' => 'varchar(255) NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'password' => 'varchar(255) NOT NULL',
            'created_at' => 'timestamp NOT NULL DEFAULT current_timestamp()',
            'pin' => 'int(8) NULL',
        ],
        'primary_key' => 'id',
        'unique_keys' => ['email']
    ]
];
?>