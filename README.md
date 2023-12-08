# library_mgmt

#Steps to set up the code
1. Create a database ‘library’ 
2. Run command ‘php artisan db:seed —class=UserSeeder
3. Run this command ‘composer update’
4. Run this command for run project ‘php artisan serve’

#APIDevelopment
We have developed a robust API using Laravel 10.10 to handle data retrieval and manipulation. 

#FrontendImplementation
For the frontend, we utilized the Laravel Blade templating engine, creating a seamless and efficient user interface.

#Authentication
ForAPIauthentication,weimplementedLaravelPassport,ensuringsecureandreliable accesscontrol.Userscanloginusingthefollowingcredentials:
● Email:demo@gmail.com
● Password:Password123#

#FrontendInteraction:
○ AccessthefrontendviewscreatedusingLaravelBlade.
○ IntegrationofDataTablesforeﬃcientdatapresentationandpagination.
○ Inlistingofbookswehaveshow‘hereinafter’librarybooks

#Authentication
Loginusingtheprovidedcredentials:
■ Email:demo@gmail.com
■ Password:Password123#

#Description
● WehavecreateaAuthorAPIs(Addauthor,Updateauthor,Deleteauthor,Author detail,Listauthor)
● WehavecreateaBookAPIs(AddBook,Updatebook,Deletebook,Authordetail, Listbook)
● Foraddapiofbookweneedtopassname,author_id(arrayformat),library_id, image
● Weinsertthebookdatainthebookstable.
● Foraddingapitheauthorneedstopassnameandemailandweinsertintothe authorstable.
● Forupdating,show anddeleteAPI(AuthorandBook)needstopassifinurl.
