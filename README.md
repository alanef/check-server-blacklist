# Check Server Black List #
## Purpose ##
This is a simple WordPress plugin to check the logic of Spamhaus ZEN blacklist look up to validate the process
## Installation ##
Find the green *CODE* button above, and find the *Download ZIP* link and download.

Install and activate as normal WordPress plugin.
## Use ##
Add the shortcode [csb] to a temporary page or  post and view the page
## Expected results ##

If the server is not on a black list output would be similar to 

>Got IP from $_SERVER['SERVER_ADDR'] - IP value 192.168.144.4

>FILTER_FLAG_IPV4 IP appears to be an IPv4

>FILTER_FLAG_IPV6 IP appears to be an IPv4

>gethostbyname() seems to work OK

>IPv4 so checking blacklist

>gethostbyname() returned 4.144.168.192.zen.spamhaus.org in blacklist check of 4.144.168.192.zen.spamhaus.org - this means that Spamhaus ZEN has NOT listed this IP in a Blacklist

>(note the IP is reversed for the Spamhuas look up - that is what is needed)