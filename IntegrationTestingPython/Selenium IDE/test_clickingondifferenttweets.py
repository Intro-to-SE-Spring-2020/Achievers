# Generated by Selenium IDE
import pytest
import time
import json
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities

class TestClickingondifferenttweets():
  def setup_method(self, method):
    self.driver = webdriver.Chrome()
    self.vars = {}
  
  def teardown_method(self, method):
    self.driver.quit()
  
  def test_clickingondifferenttweets(self):
    self.driver.get("http://localhost/Achievers/HTML/Home.html")
    self.driver.set_window_size(1349, 730)
    self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(1) > .middle").click()
    self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(1) > .middle").click()
    self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(1) > .middle").click()
    element = self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(1) > .middle")
    actions = ActionChains(self.driver)
    actions.double_click(element).perform()
    self.driver.find_element(By.ID, "tweetUser").click()
    self.driver.find_element(By.ID, "tweetUser").click()
    element = self.driver.find_element(By.ID, "tweetUser")
    actions = ActionChains(self.driver)
    actions.double_click(element).perform()
    self.driver.find_element(By.ID, "like").click()
    self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(1) > .middle").click()
    self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(2) #like").click()
    self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(2) > .middle").click()
    self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(2) > .middle").click()
    element = self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(2) > .middle")
    actions = ActionChains(self.driver)
    actions.double_click(element).perform()
    self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(2) > .middle").click()
    self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(2) > .middle").click()
    element = self.driver.find_element(By.CSS_SELECTOR, ".c:nth-child(2) > .middle")
    actions = ActionChains(self.driver)
    actions.double_click(element).perform()
    self.driver.find_element(By.ID, "1likes").click()
    self.driver.find_element(By.ID, "1likes").click()
    element = self.driver.find_element(By.ID, "1likes")
    actions = ActionChains(self.driver)
    actions.double_click(element).perform()
    self.driver.find_element(By.ID, "1likes").click()
  
