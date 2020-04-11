'''
SeleniumBrowserTesting.py
Uses the selenium framework to test if the Achievers web app works as expected

'''

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from os import startfile

from signup_test import TestAchieversSite

'''
use_def = input("Use defaults? (y/n)").lower()
yeses = ["yes", "y", 'ye']
nos = ["no","n"]

while use_def not in yeses + nos:
    print("That's not a valid response...")
    use_def = input("Use defaults? (y/n)").lower()

if use_def in yeses:
    repoDirectory = "C:\\xampp\\htdocs\\Achievers"
    xamppLinkAddress = repoDirectory + "\\IntegrationTestingPython\\xampp-control.lnk"
    try:
        startfile(xamppLinkAddress)
    except Exception as e:
        print("Error:", e, " Which really means the xampp stuff couldn't be started.")

elif use_def in nos:
    repoDirectory = input("Please enter (copy/paste) the repository directory")
    wait = input("Please start the database, then press Enter.")
    if wait is not None:
        wait = None
'''

driver = webdriver.Firefox()
try:
    test = TestAchieversSite()
    test.run(driver=driver) # actually running the tests
except Exception as e:
    print(e)
finally:
    test.teardown_method()
