<?php

class MobWeb_UpdateChildProducts_Model_Observer
{

	public function catalogProductSaveAfter($observer)
	{
		$product = $observer->getProduct();
		$log = Mage::helper('MobWeb_UpdateChildProducts/log');

		if(!$product) {
			$log->log('Unable to load product');
		}

		$log->log('catalogProductSaveAfter called for product: ' . $product->getId());

		// Check if the product is a configurable product. If not, abort
		if(!$product->isConfigurable()) {
			$log->log('Product is not configurable, skipping: ' . $product->getId());

			return;
		}

		// Get the attributes from the parent product that we want to update on the child products
		$updateAttributes = array(
			'short_description' => $product->getData('short_description'),
			'description' => $product->getData('description'),
			'price' => $product->getData('price'),
			'special_price' => $product->getData('special_price'),
		);

		// Load the product's child products
		$childProductIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getChildrenIds($product->getId());
		$childProductIds = is_array($childProductIds) ? array_values($childProductIds) : array();
		$childProductIds = array_pop($childProductIds);
		$childProductIds = array_values($childProductIds);

		if($childProductIds && count($childProductIds)) {

			foreach($childProductIds AS $childProductId) {
				$childProduct = Mage::getModel('catalog/product')->load($childProductId);

				if($childProduct) {
					$log->log(sprintf('Child product %s loaded from parent product %s', $childProductId, $product->getId()));

					// Update the attributes on the child product
					foreach($updateAttributes AS $attribute => $value) {
						$childProduct->setData($attribute, $value);
						$log->log(sprintf('Updated attribute %s for child product %s, new value: %s', $attribute, $childProductId, $value));
					}

					// Save the child product
					$childProduct->save();
					$log->log(sprintf('Child product %s saved', $childProductId));
				} else {
					$log->log(sprintf('Unable to load child product %s from parent product %s', $childProductId, $product->getId()));
				}
			}
		} else {
			$log->log('No child products found for parent product %s', $product->getId());
		}
	}
}