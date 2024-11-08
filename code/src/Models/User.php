<?php

namespace Geekbrains\Application1\Models;

class User {

    private ?string $userName;
    private ?int $userBirthday;

    private static string $storageAddress = '/storage/birthdays.txt';

    public function __construct(string $name = null, int $birthday = null){
        $this->userName = $name;
        $this->userBirthday = $birthday;
    }

    public function setName(string $userName) : void {
        $this->userName = $userName;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getUserBirthday(): int {
        return $this->userBirthday;
    }

    public function setBirthdayFromString(string $birthdayString) : void {
        $this->userBirthday = strtotime($birthdayString);
    }

    public static function getAllUsersFromStorage(): array|false
    {
        $address = $_SERVER['DOCUMENT_ROOT'] . self::$storageAddress;
    
        if (file_exists($address) && is_readable($address)) {
            $file = fopen($address, "r");
    
            if ($file === false) {
                return false; // Файл не удалось открыть
            }
    
            $users = [];
    
            while (($userString = fgets($file)) !== false) {
                $userArray = explode(",", $userString);
    
                // Проверяем, что в массиве есть минимум два элемента
                if (count($userArray) >= 2) {
                    $user = new User(
                        trim($userArray[0]) // Убираем лишние пробелы вокруг имени
                    );
                    $user->setBirthdayFromString(trim($userArray[1]));
    
                    $users[] = $user;
                }
            }
    
            fclose($file);
    
            return $users;
        }
    
        return false;
    }
    
}