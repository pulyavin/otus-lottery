<?php

namespace Otus;


class EmailObfuscator
{
    /**
     * Obfuscate email
     *
     * @param string $email
     *
     * @return string
     */
    public function obfuscate(string $email): string
    {
        if (mb_strpos($email , '@') === false) {
            return $email;
        }

        if (mb_strpos($email , '.') === false) {
            return $email;
        }

        $explodeByDog = explode('@', $email);
        $login = $explodeByDog[0];

        $explodeByDot = explode('.', $explodeByDog[1]);
        $host = str_repeat('*', mb_strlen($explodeByDot[0]));
        $domain = str_repeat('*', mb_strlen($explodeByDot[1]));

        return "{$login}@{$host}.{$domain}";
    }
}