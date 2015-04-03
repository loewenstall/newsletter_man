<?php

namespace LEO\NewsletterMan\ViewHelpers;

/**
 * Replace marker in confirmation mail
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class MarkerViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * @param \LEO\NewsletterMan\Domain\Model\Recipient $recipient
     * @param string $content the mail content
     * @return string
     */
    public function render(\LEO\NewsletterMan\Domain\Model\Recipient $recipient, $content) {
		$replaceContent = str_replace('#FIRST_NAME#', $recipient->getFirstName(), $content);
		$replaceContent = str_replace('#LAST_NAME#', $recipient->getLastName(), $replaceContent);
		$replaceContent = str_replace('#TITLE#', $recipient->getTitle(), $replaceContent);
		$replaceContent = str_replace('#GENDER#', \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('gender.' . $recipient->getGender(), 'newsletter_man'), $replaceContent);

		return $replaceContent;
    }
}
