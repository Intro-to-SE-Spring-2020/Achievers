'''
SeleniumBrowserTesting.py
Uses the selenium framework to test if the Achievers web app works as expected

'''

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from os import getcwd

from test_achievers_site import TestAchieversSite
import unittest
from pyunitreport import HTMLTestRunner

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

# driver = webdriver.Firefox()
# driver = webdriver.Chrome(executable_path=r"C:\Program Files (x86)\Selenium\chromedriver\chromedriver.exe")
# driver = webdriver.Chrome()


try:
    unittest.main(testRunner=HTMLTestRunner(output=getcwd()+'/output.txt'))

except Exception as e:
    print(e)
