<?php

namespace Fintech\Simplify\Entity;

use Doctrine\ORM\Mapping as ORM;
use Laminas\Hydrator\ClassMethodsHydrator;
use Fintech\Simplify\Repository\TransactionRepository;
/**
 * Mensagens
 *
 * @ORM\Table(name="transaction", indexes={
 *     @ORM\Index(name="fkey_transaction_payer_idx", columns={"payer_id"}),
 *     @ORM\Index(name="fkey_transaction_payee_idx", columns={"payee_id"})
 * })
 * @ORM\Entity(repositoryClass="TransactionRepository")
 */
class Transaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payer_id", referencedColumnName="id")
     * })
     */
    private $payer;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payee_id", referencedColumnName="id")
     * })
     */
    private $payee;

    /**
     * @ORM\Column(name="description", type="string", nullable=true, length=255)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2)
     * @var float
     */
    private $amount;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private ?\DateTime $createdAt = null;

    public function __construct(array $data = [])
    {
        $this->createdAt = new \DateTime('now');
        (new ClassMethodsHydrator())->hydrate($data, $this);
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getPayer(): User
    {
        return $this->payer;
    }

    /**
     * @param User $payer
     */
    public function setPayer(User $payer): void
    {
        $this->payer = $payer;
    }

    /**
     * @return User
     */
    public function getPayee(): User
    {
        return $this->payee;
    }

    /**
     * @param User $payee
     */
    public function setPayee(User $payee): void
    {
        $this->payee = $payee;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        return (new ClassMethodsHydrator())->extract($this);
    }
}
