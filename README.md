newspost
========
To run the project:

composer update
bin/console doctrine:migrations:migrate
npm install
./node_modules/.bin/encore production
install wkhtmltopdf

I did not have enough time for all the functionality required by the task. 
I did not make  rss feed service and just started the tests. 
I made registration with an verification link on email, which redirect to a password change and login/logout functionality. 
User can create news with multiple file upload, can delete his own news and changes news status to published with button. 
Without authentication users see 10 news. Visitor is able to view a complete article and to download in pdf. 
Because I had a code written for news listing with React.js - I attached it as a second version of the news listing without  аuthentication.

