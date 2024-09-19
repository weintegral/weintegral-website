# Snippets


### How to send email?

```php

Mail::to('info@weintegral.com')
    ->cc('s.gopibabu@gmail.com')
    ->bcc('hr@weintegral.com')
    ->send(new WelcomeEmail("Gopibabu"));

```
