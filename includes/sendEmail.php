<?php
$to = "rpm1977@gmail.com";
$subject = "From the site";
$body = 'Full Name: '. $formData->name ."\n".
        'Contact Email: '. $formData->email ."\n".
        'Contact Number: '. $formData->phone ."\n".
        'Where did you hear about Tattooin AZ: '. preg_replace('/-/', ' ', $formData->hear) ."\n".
        'Is this your first tattoo: '. preg_replace('/-/', ' ', $formData->first) ."\n".
        'What kind of tattoo are you wanting: '. preg_replace('/-/', ' ', $formData->kind) ."\n".
        'Message to Dave: '. $formData->message;
mail($to, $subject, $body) or $formData->global->m = '<div>Sorry the email wasn\t send please try agian.</div>';



?>
