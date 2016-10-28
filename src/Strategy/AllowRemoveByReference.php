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

/**
 * Class AllowRemoveByReference
 *
 * @package   Zend\Hydrator\Doctrine\Strategy
 * @link      http://github.com/jguittard/zend-hydrator-doctrine For the canonical source repository
 * @copyright 2016 Doctrine Project
 * @license   http://opensource.org/licenses/MIT MIT License
 */
class AllowRemoveByReference extends AbstractCollectionStrategy
{
    /**
     * {@inheritDoc}
     */
    public function hydrate($value)
    {
        $collection      = $this->getCollectionFromObjectByReference();
        $collectionArray = $collection->toArray();
        $toAdd    = array_udiff($value, $collectionArray, [$this, 'compareObjects']);
        $toRemove = array_udiff($collectionArray, $value, [$this, 'compareObjects']);
        foreach ($toAdd as $element) {
            $collection->add($element);
        }
        foreach ($toRemove as $element) {
            $collection->removeElement($element);
        }
        return $collection;
    }
}
