# Who let the cats out?
Important note: this graded exercise must be done individually.

They say that a dog is a man's best friend. We can say otherwise. Cats can also be man's best friend. They love humans more than they love food. Counting more than half a billion individuals and over 70 different breeds, cats are one of the world's most popular pets. They are a sociable species, despite their love for exploring and hunting. Their communcation skills can be a little though as they do it through meowing, purring or sometimes grunting, but hey, they are still cute.

## Pre-requisites and requirements

To be able to create this web app, you are going to need a local environment suited with:

1. Web server (Nginx)
2. PHP 8
3. MySQL
4. Composer

You have to use the Docker `local-environment` set up that we have been using in class.

## Resources

### MySQL

Use the [schema.sql](./resources/schema.sql "Schema SQL") provided as part of this exercise to create the tables in the MySQL database.

### Guzzle

You will need to request information from an external API during the exercise. You MUST use [Guzzle](https://docs.guzzlephp.org/en/stable/).

## Exercise

To complete the exercise, you will need to create three different pages:

1. Register
2. Login
3. Search

### Register

For this page, you have to create a file called `register.php` that displays a register form containing two fields:

1. Email - must be a valid email
2. Password - must contain at least one number, one capital letter, one small letter, and should be longer than or equal to 7 characters

When the form is submitted, you need to validate the data from the form. All the validation errors must be displayed under the corresponding input field.
If the registration is successful, you need to [(HTTP) redirect](https://developer.mozilla.org/en-US/docs/Web/HTTP/Redirections) the user to the login page.

### Login

For this page, you have to create a file called `login.php` that is going to display a login form containing two fields:

1. Email
2. Password

When the form is submitted, you need to validate the data from the form **using the same validations as in the registration**. All the validation errors must be displayed under the corresponding input field.

If all the data is correct, you will have to check if the user exists in the database to log him in (**you need to start a session for the user**). If the user is not found, you need to display an error in the form.

### Search

If users try to manually access to this page without being logged in, they should be redirected to the login page.

For this page, you have to create a file called `search.php` that is going to display a search form containing just one input field where the user will enter the search string.

Once the form is submitted, first you need to store the search for the current user in the database. Every search will be associated to the logged user to keep the user's search strings history.

After that, you will have to do an **API call** to the [Cats API](https://thecatapi.com/) to search for Cats. After receiving the response, you will have to display the pictures of the Cats **in the form of a gallery**. This means that the pictures should not be shown in "list form", but more like in a "grid". Aside from the Cat picture, you also have to display its height and width.

To use the **Cat API**, first you need to [sign up for free](https://thecatapi.com/signup) and then the API key will be sent to your email. You will use this API Key to make the calls to the [Search by breed endpoint](https://docs.thecatapi.com/example-by-breed): https://api.thecatapi.com/v1/images/search.

```
$apiUrl = "https://api.thecatapi.com/v1/images/search?breed_ids=$breed_id";
```

Notice that `$breed_id` corresponds to the text to search for. To know what kind of breeds to search for, you can send a GET request to the Breed endpoint: https://api.thecatapi.com/v1/breeds.

For authentication, use your API key to add it to the request headers (secure way) or query parameters (less secure way). For more information, checkout the [documentation on Authentication](https://docs.thecatapi.com/authentication).

Optionally, you can show only up to **30 cats** with the given search input by experimenting with the request parameters from the [documentation](https://docs.thecatapi.com/).

## Delivery

### Requirements

Besides using Guzzle, you MUST use the structures available in Object-Oriented Programming, at least classes and objects.

### Format

You must upload a .zip file with the filename format `AC1_<your_login>.zip` containing all the code to the eStudy.