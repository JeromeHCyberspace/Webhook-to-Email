Now you need to configure mailgun.<br><br>

In Heroku, click "Resources" and then click Mailgun.<br><br>

In Mailgun, click SENDING, then click DOMAINS, then click the sandbox domain they provided you.<br><br>

Scroll down, then add your email (same value from before in environment variable YOUR_EMAIL) to "Authorized Recipients". This will send you a verification email that MAY go to spam. Click the link in the verification email.<br><br>

Now in game set your Webhook URL to the following value: <span id='webhook_url'></span>
<script>
document.getElementById('webhook_url').innerHTML = window.location.href.replace('/postinstall.php', '/webhook.php');
</script>
<br><br>
----------------<br>
To prevent these webhook notification emails from going to spam, click "SEND TEST WEBHOOK" in HCS settings page. Open your spam folder, find the email you just received, and click "Not Spam" - and for good measure, consider adding that address to your contact list.