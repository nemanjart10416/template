<?php

class Email {
    /**
     * @var string
     */
    private string $adminEmail = "admin@gmail.com";
    /**
     * @var string
     */
    private string $domain = "domain.com";
    /**
     * @var string
     */
    private string $emailFrom = "email@domain.com";

    /**
     * @param string $email
     * @param string $subject
     * @param string $name
     * @param string $message
     * @return bool
     */
    public function sendMail(string $email, string $subject, string $name, string $message): bool {
        $from = $this->getEmailFrom();

        $header = "From: $from\r\n";
        $header .= "Cc: $from\r\n";
        $header .= "X-Sender: <$from>\n";
        $header .= 'X-Mailer: PHP/' . phpversion();
        $header .= "X-Priority: 1\n"; // Urgent message!
        $header .= "Return-Path: $from\n"; // Return path for errors
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";

        return mail($email, $subject, $message, $header);
    }

    /**
     * @return string
     */
    public function getAdminEmail(): string {
        return $this->adminEmail;
    }

    /**
     * @param string $adminEmail
     */
    public function setAdminEmail(string $adminEmail): void {
        $this->adminEmail = $adminEmail;
    }

    /**
     * @return string
     */
    public function getDomain(): string {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getEmailFrom(): string {
        return $this->emailFrom;
    }

    /**
     * @param string $emailFrom
     */
    public function setEmailFrom(string $emailFrom): void {
        $this->emailFrom = $emailFrom;
    }



}