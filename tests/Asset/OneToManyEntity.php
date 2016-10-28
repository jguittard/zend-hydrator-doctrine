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

namespace ZendTest\Hydrator\Doctrine\Asset;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class OneToManyEntity
 *
 * @package   ZendTest\Hydrator\Doctrine\Asset
 * @link      http://github.com/jguittard/zend-hydrator-doctrine For the canonical source repository
 * @copyright 2016 Doctrine Project
 * @license   http://opensource.org/licenses/MIT MIT License
 */
class OneToManyEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Collection
     */
    protected $entities;

    /**
     * OneToManyEntity constructor.
     */
    public function __construct()
    {
        $this->entities = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param Collection $entities
     * @param bool $modifyValue
     */
    public function addEntities(Collection $entities, $modifyValue = true)
    {
        foreach ($entities as $entity) {
            // Modify the value to illustrate the difference between by value and by reference
            if ($modifyValue) {
                $entity->setField('Modified from addEntities adder', false);
            }
            $this->entities->add($entity);
        }
    }

    /**
     * @param Collection $entities
     */
    public function removeEntities(Collection $entities)
    {
        foreach ($entities as $entity) {
            $this->entities->removeElement($entity);
        }
    }


    /**
     * @return Collection
     */
    public function getEntities()
    {
        return $this->entities;
    }
}
