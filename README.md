# MobWeb_UpdateChildProducts extension for Magento

A simple Magento extension that can be used to automatically update a Configurable Product's Child Products upon saving. For example if you updated the Configurable Product's price, all the Child Product's prices would also be updated. Modify the `MobWeb_UpdateChildProducts_Model_Observer::catalogProductSaveAfter` method to indicate which attributes should be updated.

## Installation

Install using [colinmollenhour/modman](https://github.com/colinmollenhour/modman/).

## Questions? Need help?

Most of my repositories posted here are projects created for customization requests for clients, so they probably aren't very well documented and the code isn't always 100% flexible. If you have a question or are confused about how something is supposed to work, feel free to get in touch and I'll try and help: [info@mobweb.ch](mailto:info@mobweb.ch).