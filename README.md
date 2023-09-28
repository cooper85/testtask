**Test Task Module**
**Tested compatibility with Magento 2.4.5-p2**
- Add a custom customer attribute “Hobby“ with possible options: “Yoga“, “Traveling“, “Hiking“. The attribute is not required.
- Add a possibility to fetch / edit the attribute using GraphQL.
- Admin must be able to edit the attribute in admin panel.
- Add a link in the customer account menu.
- The link must lead on the page “Edit Hobby“. There must be a form with one field “Hobby“ and submit button.
- “Hobby“ must be displayed in the top right corner in the format “Hobby: %s“ and must be correspond to the current customer hobby. Place it right away after the welcome message. 
NB! Notice that it must work correctly with all enabled Magento caches

**Admin configuration could be found under**
Customer / Account Information / Display Hobby Section

**Frontend changes could be visible by**
Customer Account Dashboard / Hobby List - hobby/manage/index
For logged-in customers header welcome message should be displayed as Welcome %NAME%, (%HOBBY LIST%) !

**Tested with enabled FPC for reflection of interactive customer account changes**

**GraphQL usage example**

1.Retrieve customer token
request example:
mutation {
    generateCustomerToken(email: "own_email@gmail.com", password: "secret_password") {
        token
    }
}
response example:
{
    "data": {
        "generateCustomerToken": {
            "token": "eyJraWQiOiIxIiwiYWxnIjoiSFMyNTYifQ.eyJ1aWQiOjEsInV0eXBpZCI6MywiaWF0IjoxNjk1NzIyMTMxLCJleHAiOjE2OTU3MjU3MzF9.uqcm-oTaFiqXAotLJmgCDy2CauW7MD9fVMkBDCyPKgQ"
        }
    }
}

2. Retrieve customer email and hobbies using customer token for auth
request example:
{
   customer {
       email,
       hobby
   }
}
response example:
{
   "data": {
   "customer": {
           "email": "sergeizubinskiy@gmail.com",
           "hobby": [
               "Travelling",
               "Hiking"
           ]
       }
   }
}

3. Update customer hobbies using customer token for auth
request example:
mutation {
    updateCustomer(
        input: {
            hobby: [
                "travelling",
                "hiking",
                "yoga"
            ]
        }
    ) {
        customer {
            hobby
        }
    }
}
response example:
{
   "data": {
      "updateCustomer": {
         "customer": {
            "hobby": [
               "travelling",
               "hiking",
               "yoga"
            ]
         }
      }
   }
}