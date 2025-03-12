<?php
function formatPhoneNumber($phone) {
    $cleanedPhone = preg_replace('/\D/', '', $phone);
    if (strpos($cleanedPhone, '55') !== 0) {
        $regex = '/^(\d{2})(\d{8,9})$/';

        if (!preg_match($regex, $cleanedPhone, $matches)) {
            return null;
        }

        $cleanedPhone = "55" . $cleanedPhone;
    } else {
        $cleanedPhone = preg_replace('/^55/', '', $cleanedPhone);

        $regex = '/^(\d{2})(\d{8,9})$/';

        if (!preg_match($regex, $cleanedPhone, $matches)) {
            return null;
        }

        $cleanedPhone = "55" . $cleanedPhone;
    }

    return $cleanedPhone;
}
