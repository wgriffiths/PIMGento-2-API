<?php

namespace Pimgento\Api\Model\Source\Filters;

use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use Akeneo\Pim\ApiClient\Pagination\ResourceCursorInterface;
use Magento\Framework\Option\ArrayInterface;
use Pimgento\Api\Helper\Authenticator;

/**
 * Class Family
 *
 * @category  Class
 * @package   Pimgento\Api\Model\Source\Filters
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2018 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.pimgento.fr/
 */
class Family implements ArrayInterface
{
    /**
     * This variable contains a mixed value
     *
     * @var Authenticator $akeneoAuthenticator
     */
    protected $akeneoAuthenticator;

    /**
     * Family constructor
     *
     * @param Authenticator $akeneoAuthenticator
     */
    public function __construct(
        Authenticator $akeneoAuthenticator
    ) {
        $this->akeneoAuthenticator = $akeneoAuthenticator;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        /** @var ResourceCursorInterface $families */
        $families = $this->getFamilies();

        $options = [];
        foreach ($families as $family) {
            $options[] = [
                'label' => $family['code'],
                'value' => $family['code'],
            ];
        }

        return $options;
    }

    /**
     * Retrieve the families from akeneo using the configured API. If the credentials are not configured or are wrong, return an empty array
     *
     * @return ResourceCursorInterface|array
     */
    private function getFamilies()
    {
        try {
            /** @var AkeneoPimClientInterface $akeneoClient */
            $akeneoClient = $this->akeneoAuthenticator->getAkeneoApiClient();

            if (!$akeneoClient) {
                return [];
            }

            return $akeneoClient->getFamilyApi()->all();

        } catch (\Exception $exception) {
            return [];
        }
    }
}
