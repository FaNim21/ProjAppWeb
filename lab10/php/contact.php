<?php

function PokazKontakt()
{
    $wynik = '
    <h2>Wyślij wiadomość</h2>
    <form method="post" class="contact-form">
      <label for="temat">Temat:</label>
      <input type="text" id="temat" name="temat" required /><br />
      <label for="email">e-mail:</label>
      <input type="email" id="email" name="email" required /><br />
      <label for="message">Wiadomość:</label><br />
      <textarea id="message" name="tresc" rows="4" required></textarea><br />
      <input type="submit" name="send" value="Wyślij" />
      </form>
    <form method="post">
      <input type="submit" name="back" value="Powrot" />
    </form>
    ';
    return $wynik;
}

function WyslijMainKontankt($odbiorca)
{
    if (empty($_POSTp['temat']) || empty($_POSTp['tresc']) || empty($_POSTp['email'])) {
        echo '[nie_wypelniles_pola]';
    } else {
        $mail['subject'] = $_POST['temat'];
        $mail['body'] = $_POST['tresc'];
        $mail['sender'] = $_POST['email'];
        $mail['reciptient'] = $odbiorca;

        $header = "From: Formularz kontaktowy <" . $mail['sender'] . ">\n";
        $header .= "MimE-Version 1.0\nContent-Type: text/plain; charset-utf-8\nContent-Transfer-Encoding: ";
        $header .= "X-Sender: <" . $mail['sender'] . ">\n";
        $header .= "X-Mailer: PRapWWW mail 1.2\n";
        $header .= "X-Priority: 3\n";
        $header .= "Return-Path: <" . $mail['sender'] . ">\n";

        mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);
        echo '[wiadomosc_wyslana]';
    }
}

function PrzyPomnijHaslo()
{
    $wynik = '
    <h2>Wyślij wiadomość</h2>
    <form action="mailto:picore6014@ksyhtc.com" method="post" class="contact-form">
      <label for="name">Temat:</label>
      <input type="text" id="name" name="temat" required /><br />
      <label for="email">e-mail:</label>
      <input type="email" id="email" name="email" required /><br />
      <label for="message">Wiadomość:</label><br />
      <textarea id="message" name="tresc" rows="4" required></textarea><br />
      <input type="submit" name="send" value="Wyślij" />
      <input type="submit" name="back" value="Powrot" />
    </form>
    ';
    return $wynik;
}
