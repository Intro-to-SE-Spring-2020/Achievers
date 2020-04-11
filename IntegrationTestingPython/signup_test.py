# Generated by Selenium IDE
import pytest
import time
import logging, sys
import json
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
from datetime import datetime
from time import sleep

logging.basicConfig(filename='Achievers_Testing.log', level=logging.INFO)
signup_logger = logging.getLogger("IntegrationTestingPython.signup_test")


# For logging purposes
def excepthook(*args):
    logging.getLogger(signup_logger).error('Uncaught exception:', exc_info=args)


sys.excepthook = excepthook


def page_change_wait_and_assert(driver=None, string_in_title=None):
    if driver is None or string_in_title is None:
        print("Incorrect usage of WaitForPageChange function")
        return False
    try:
        WebDriverWait(driver, 5).until(expected_conditions.title_contains(string_in_title))
        assert string_in_title.lower() in driver.title.lower()
        return True
    except AssertionError:
        return False

def generate_new_username():
    time_str = str(datetime.now())
    return "Test User " + time_str[:time_str.find(".")]

class TestAchieversSite:
    def setup_method(self, driver, method=None):
        self.driver = driver  # to take input
        self.entries = [["Username", generate_new_username()], ["Email", "TestEmail@email.com"],
                        ["Password", "TestPass"], ["ConfirmPass", "Wrong"]]
        self.vars = {}

    def run(self, driver):
        self.setup_method(driver=driver)
        self.test_signup_login()
        self.test_home_page_interactions()
        self.teardown_method()

    def teardown_method(self, method=None):
        self.driver.quit()

    def test_signup_login(self):

        # Start the browser
        self.driver.get("http://localhost/Achievers/HTML/signup.html")
        assert "signup" in self.driver.title.lower()
        print("On signup page")

        # Send in test data (mess up the confirmation password)
        for entry in self.entries:
            #print(entry[0], entry[1])
            self.driver.find_element(By.ID, entry[0]).send_keys(entry[1])

        # Click button, the output should show that the passwords do not match
        self.driver.find_element(By.CSS_SELECTOR, "button").click()
        output = self.driver.find_element(By.ID, "output").text
        assert all(word in output.lower() for word in ["password", "match"])

        # Fix the password (clear field first) and click on button
        #print(self.entries[3][0], self.entries[2][1])
        cp = self.driver.find_element(By.ID, self.entries[3][0])
        cp.clear()
        cp.send_keys(self.entries[2][1])
        self.driver.find_element(By.CSS_SELECTOR, "button").click()

        # wait, then should be taken to the login page
        # From https://selenium-python.readthedocs.io/waits.html
        if not page_change_wait_and_assert(driver=self.driver, string_in_title="Login"):
            return

        print("On login page")

        login_testing_entries = [[generate_new_username(), self.entries[2][1]],     # wrong username, correct pass
                                 [self.entries[0][1], "badWords"]]                  # Correct username, wrong pass

        sleep(1)
        # Enter in incorrect username/password, press enter on button
        user_field = self.driver.find_element(By.ID, "Username")
        pass_field = self.driver.find_element(By.ID, "Password")
        for login_entry in login_testing_entries:
            user_field.send_keys(login_entry[0])
            pass_field.send_keys(login_entry[1])
            self.driver.find_element(By.CSS_SELECTOR, "button").click()
            output = self.driver.find_element(By.ID, "output").text
            assert "incorrect" in output.lower()
            #clear fields
            user_field.clear()
            pass_field.clear()

        # Enter in correct username/password, press enter on button (username and password are 0th and 2nd items)
        self.driver.find_element(By.ID, "Username").send_keys(self.entries[0][1])
        self.driver.find_element(By.ID, "Password").send_keys(self.entries[2][1])
        self.driver.find_element(By.CSS_SELECTOR, "button").click()

        # wait, then should be taken to the home page
        # From https://selenium-python.readthedocs.io/waits.html
        if not page_change_wait_and_assert(driver=self.driver, string_in_title="Home"):
            print("Did not go to home page!")
            return
        print("Sign up and Login successful! - At home page")

    def test_home_page_interactions(self):
        # Still on home page from other
        if "home" not in self.driver.title.lower():
            raise AssertionError("Driver was not on home page at start of home page testing.")
            return
        print("On home page")

        # Check that still logged in
        self.driver.find_element(By.ID, "click").click()
        username = self.driver.find_element(By.ID, "theuser")
        assert username == self.entries[0][1]

        # Make a tweet
        print("Posting a tweet")
        username = self.entries[0][1]
        #self.driver.find_element(By.ID, "tweetBody").click()
        self.driver.find_element()
        self.driver.find_element(By.ID, "tweetBody").send_keys(username + "'s new tweet test")
        self.driver.find_element(By.CSS_SELECTOR, ".btn").click()
        tweet_text = self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(1) > .middle").text
        assert username in tweet_text
        print("Tweet Posted!")


        print("Liking a tweet...")
        self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(1) #like").click()

        self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(1) #follow").click()
        self.driver.find_element(By.LINK_TEXT, "Following").click()
        self.driver.find_element(By.LINK_TEXT, "Write Something").click()
        self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(2) #reply").click()

        '''
        self.driver.find_element(By.CSS_SELECTOR, "button").click()
        self.driver.find_element(By.ID, "Username").click()
        self.driver.find_element(By.ID, "Username").send_keys("testname")
        self.driver.find_element(By.ID, "Password").send_keys("testpassword")
        self.driver.find_element(By.CSS_SELECTOR, "button").click()
        self.driver.find_element(By.ID, "Password").click()
        self.driver.find_element(By.ID, "Password").click()
        element = self.driver.find_element(By.ID, "Password")
        actions = ActionChains(self.driver)
        actions.double_click(element).perform()
        self.driver.find_element(By.ID, "Password").send_keys(Keys.ENTER)
        self.driver.find_element(By.ID, "Password").send_keys("testpassword")
        self.driver.find_element(By.CSS_SELECTOR, "button").click()
        self.driver.find_element(By.ID, "Password").click()
        self.driver.find_element(By.ID, "Password").send_keys(Keys.ENTER)
        self.driver.find_element(By.ID, "Password").send_keys("testpassword")
        self.driver.find_element(By.CSS_SELECTOR, "button").click()
        self.driver.find_element(By.ID, "Password").click()
        self.driver.find_element(By.ID, "Password").send_keys("test password")
        self.driver.find_element(By.ID, "Password").send_keys(Keys.ENTER)
        self.driver.find_element(By.ID, "Password").click()
        self.driver.find_element(By.ID, "Password").send_keys("testpass")
        self.driver.find_element(By.ID, "Password").send_keys(Keys.ENTER)
        self.driver.find_element(By.CSS_SELECTOR, "button").click()
        element = self.driver.find_element(By.CSS_SELECTOR, "button")
        actions = ActionChains(self.driver)
        actions.move_to_element(element).perform()
        element = self.driver.find_element(By.CSS_SELECTOR, "body")
        actions = ActionChains(self.driver)
        actions.move_to_element(element, 0, 0).perform()
        self.driver.find_element(By.CSS_SELECTOR, ".header-right").click()
        self.driver.find_element(By.ID, "click").click()
        self.driver.find_element(By.CSS_SELECTOR, ".fa-meh").click()
        self.driver.find_element(By.ID, "tweetBody").click()
        self.driver.find_element(By.ID, "tweetBody").send_keys("new tweet test")
        self.driver.find_element(By.CSS_SELECTOR, ".btn").click()
        element = self.driver.find_element(By.CSS_SELECTOR, ".btn")
        actions = ActionChains(self.driver)
        actions.move_to_element(element).perform()
        element = self.driver.find_element(By.CSS_SELECTOR, "body")
        actions = ActionChains(self.driver)
        actions.move_to_element(element, 0, 0).perform()
        self.driver.find_element(By.ID, "like").click()
        self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(2) #follow").click()
        self.driver.find_element(By.LINK_TEXT, "Following").click()
        self.driver.find_element(By.LINK_TEXT, "Write Something").click()
        self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(2) #reply").click()
        self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(2) #like").click()
'''