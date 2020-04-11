'''
SeleniumBrowserTesting.py
Uses the selenium framework to test if the Achievers web app works as expected

'''

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from os import startfile

use_def = input("Use defaults? (y/n)").lower()
yeses = ["yes", "y", 'ye']
nos = ["no","n"]

while use_def not in yeses + nos:
    print("That's not a valid response...")
    use_def = input("Use defaults? (y/n)").lower()

if use_def in yeses:
    repoDirectory = "C:\\xampp\\htdocs\\Achievers"
    xamppLinkAddress = repoDirectory + "\\IntegrationTestingPython\\xampp-control.lnk"

elif use_def in nos:
    repoDirectory = input("Please enter (copy/paste) the repository directory")
    wait = input("Please start the database, then press Enter.")
    if wait is not None:
        wait = None

try:
    startfile(xamppLinkAddress)
except Exception as e:
    print("Error:", e, " Which really means the xampp stuff couldn't be started.")



driver = webdriver.Firefox()
driver.get("http://localhost/Achievers/Signup.html")
assert "signup" in driver.title

entries = (("username", "Test User"), ("email", "TestEmail@email.com"),
           ("password", "Test Password"), ("password", "Test Password") )
elem = driver.find_element_by_name("username")
elem.clear()
elem.send_keys("Test User")
elem = driver.find_element_by_name("username")
elem = elem.send_keys("TestEmail@email.com")
driver.find_element_by_name(Keys.TAB)
elem.send_keys("TestPassword")
driver.find_element_by_name(Keys.TAB)
elem.send_keys("TestPassword")
driver.find_element_by_name(Keys.TAB)
elem.send_keys(Keys.RETURN)

assert "No results found." not in driver.page_source
driver.close()

'''
except Exception as e:
    print(e)'''

