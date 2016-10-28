<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Zend\Hydrator\Doctrine\Strategy;

use Doctrine\Common\Collections\Collection;
use LogicException;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class DisallowRemoveByValue
 *
 * @package   Zend\Hydrator\Doctrine\Strategy
 * @link      http://github.com/jguittard/zend-hydrator-doctrine For the canonical source repository
 * @copyright 2016 Doctrine Project
 * @license   http://opensource.org/licenses/MIT MIT License
 */
class DisallowRemoveByValue extends AbstractCollectionStrategy
{
    /**
     * {@inheritDoc}
     */
    public function hydrate($value)
    {
        // AllowRemove strategy need "adder"
        $adder = 'add' . ucfirst($this->collectionName);
        if (! method_exists($this->object, $adder)) {
            throw new LogicException(
                sprintf(
                    'DisallowRemove strategy for DoctrineModule hydrator requires %s to
                     be defined in %s entity domain code, but it seems to be missing',
                    $adder,
                    get_class($this->object)
                )
            );
        }
        $collection = $this->getCollectionFromObjectByValue();
        if ($collection instanceof Collection) {
            $collection = $collection->toArray();
        }
        $toAdd = new ArrayCollection(array_udiff($value, $collection, [$this, 'compareObjects']));
        $this->object->$adder($toAdd);
        return $collection;
    }
}
