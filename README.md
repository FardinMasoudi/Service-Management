## About project

## controller

### admin

#### TicketController

It is used for managing tickets, such as listing tickets, confirming tickets, or canceling tickets.

### user

#### TicketController

It's used for managing tickets, such as listing tickets, create ticket

#### RegistrationController

It's used for register user and send verification code via email or sms

#### LoginController

It's used for login user

#### UserVerificationController

It's used to check the verification code to the user

#### ServiceController

It's used to show list of services

## Design pattern

### Factory Method Pattern:

It's used for implementing Verification code via email and sms

- Use the Factory Method Pattern when you need to create objects of a specific type, and the type of object to be
  created depends on some condition or parameter, such as the chosen verification method (email or sms).
- It's a good choice when you have a fixed set of classes (e.g., EmailVerificationCodeDriver, SMSVerificationCodeDriver)
  and you want to create instances of these classes based on runtime conditions.
- It's especially useful when you expect to add more driver types in the future, as it allows you to extend the factory
  easily.(open close principle)

## Notes
- create business with Seeder(BusinessSeeder)
- using @dataProvider directive with multiple sets of input data in tests.
- write feature and unit test and mock notification drivers
- The TicketService is used for update ticket status and send notification to user.
  First, I wanted to send the notifications from inside the observer design pattern, but it was not correct.
  Because any change in the admin section would cause a notification to be sent to the user again.
- I did not implement the access control and login logic for the admin section. In the tests, I assumed that the admin
  has the necessary access.
- run services with docker-compose (docker-compose.yml)

   



