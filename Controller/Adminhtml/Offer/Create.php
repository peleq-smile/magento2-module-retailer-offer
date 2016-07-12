<?php
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\RetailerOffer
 * @author    Romain Ruaud <romain.ruaud@smile.fr>
 * @copyright 2016 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */
namespace Smile\RetailerOffer\Controller\Adminhtml\Offer;

use Smile\RetailerOffer\Controller\Adminhtml\AbstractOffer;

/**
 * Retailer Offer Creation Controller
 *
 * @category Smile
 * @package  Smile\RetailerOffer
 * @author   Romain Ruaud <romain.ruaud@smile.fr>
 */
class Create extends AbstractOffer
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultPage = $this->createPage();

        $resultPage->setActiveMenu('Smile_Seller::retailer_offers');
        $resultPage->getConfig()->getTitle()->prepend(__('New Retailer Offer'));

        $this->coreRegistry->register("current_offer", $this->offerFactory->create([]));

        /** @TODO Delete This : Testing purpose */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $manager = $om->get('Magento\Store\Model\StoreManagerInterface');
        $this->coreRegistry->register("current_store", $manager->getStore(0));
        /** END @TODO DELETE */

        return $resultPage;
    }
}