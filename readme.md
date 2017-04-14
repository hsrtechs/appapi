***API Usage***

| API Name | Method | Resource URL | Options || Parameters | Headers |
| --- | --- | --- | --- | --- |
| Get All Offers | POST | /api/v1/offers | TRUE |
| Get Offer With Specific ID | POST | /api/v1/offers/{offer} | {offer} = Offer ID | TRUE |
| Get Authenticated Users | POST | /api/v1/user | TRUE |
| Register User | POST | /api/v1/user/create | {"name", "password", "number", "email", "device_id", "country"} | FALSE |
| Toggle User verification state | PATCH | /api/v1/user/verified | TRUE |
| Change User Password | PATCH | /api/v1/user/password | {"password"} | FALSE |
| Authenticate user | POST | /api/v1/user/login | {"email", "password", "device_id" } | FALSE |
| Get Credits of Authenticated user | POST | /api/v1/user/credits | TRUE |
| Request to recharge | POST | /api/v1/request/recharge | {recharge} = amount | TRUE |
| Get User With Specific ID | POST | /api/v1/user/{user} | {user} = User ID | TRUE |
| Get Credits of a Specific user | POST | /api/v1/user/{user}/credits | {user} = User ID | TRUE |
| Get availed offers | POST | /api/v1/app/installed | TRUE |
| Confirm Installation | POST | /api/v1/app/install/success | {package} = package of the installed app | TRUE |