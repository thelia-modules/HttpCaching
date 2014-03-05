<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace HttpCaching\Controller;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\Cache\CacheEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Security\AccessManager;
use Thelia\Tools\URL;


/**
 * Class HttpCaching
 * @package HttpCaching\Controller
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class HttpCaching extends BaseAdminController
{

    public function flush()
    {
        if (null !== $response = $this->checkAuth(array(), array('HttpCaching'), AccessManager::VIEW)) {
            return $response;
        }

        $event = new CacheEvent($this->container->getParameter("kernel.cache_dir") . '/http_cache');

        $this->dispatch(TheliaEvents::CACHE_CLEAR, $event);

        $this->redirect(URL::getInstance()->absoluteUrl('/admin/module/HttpCaching'));
    }
} 