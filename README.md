
# Secure User Authentication

Provide facility to user to create account into system through maintaining proper security measurement and validation.Managed session properly to control user information.Additionaly, updation of user information is implemented by the system.


## Features

- User registration. Two type of validation :
  - Empty input field.
  - Validation for unauthorized user input.
- User login.
  - Check whether unique creadential(username) is available in DB or not. 
- Data Updation
  - have facility to update data and validation have also there.
- Nice UI for user interaction.



## User guide

- User should careful and provide value to all input field.
- They should provide username and password more than 7 character.
- Email address must be valid such as `example@gmail.com` not `@gmail.com` or other invalid format.
- Have necessity of unique username and email to create account.
## Development procedure and Security

1.Take input from user and check whether input field empty or not.If yes then it show error.After this step is passed successfully , it check email is valid or not through filter_var().If not then show error again regarding email.On the otherhand,it also sanitize username through htmlspecialchars().Through this step system got protection from `XSS attack`.For validation, logical if-else block is used :
```
if(){

}else{

} 

```

2.In the time of accepting data from user, used prepare() and bind_param() by which user cannot put something unwanted and harmfull for database.Every interacton where user wanted to access database,prepare() and related other stuff is used.In this way ,this system is safe from `sql injection`.

3.Without login any user cannot access dashboard and edit page.Although they try to access through url, this is not goinig to be successfull.Dynamically changing of session variable's data in the time of performing updation operation.

```
$_SESSION['name'] = $username;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;

```

4.Password is stored securely by password_hash().
## Libraries or frameworks

Designed interface through css framework bootstrap 5 cdn. The reason of the use of it,it gives facility to use handy way to manage the layout.Provide 12 columns grid and anyone need not worry about css flex-box and grid.Through writing col-md-6 or other class , the work is done.On the otherhand , it provide many built in class to design nice and user friendly layout. 
