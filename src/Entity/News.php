<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity]
#[ORM\Table(name: 'news')]
class News implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $uuid;

    #[ORM\Column(type: "text")]
    #[SerializedName('abstract')]
    private string $title;

    #[ORM\Column(type: "text", nullable: true)]
    #[SerializedName('lead_paragraph')]
    private ?string $short;

    #[ORM\Column(type: "string", length: 255)]
    #[SerializedName('source')]
    private string $source;

    #[ORM\Column(type: "string", length: 255)]
    #[SerializedName('section_name')]
    private string $category;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[SerializedName('subsection_name')]
    private ?string $subCategory;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[SerializedName('author')]
    private ?string $author;

    #[ORM\Column(type: "string", length: 255)]
    #[SerializedName('web_url')]
    private string $link;

    #[ORM\Column(type: "datetime")]
    #[SerializedName('pub_date')]
    private \DateTime $publishedAt;

    public function getUuid(): UuidInterface|string
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getShort(): ?string
    {
        return $this->short;
    }

    public function setShort(?string $short): void
    {
        $this->short = $short;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getSubCategory(): ?string
    {
        return $this->subCategory;
    }

    public function setSubCategory(?string $subCategory): void
    {
        $this->subCategory = $subCategory;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    public function getPublishedAt(): \DateTime
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTime $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'title' => $this->title,
            'short' => $this->short,
            'source' => $this->source,
            'category' => $this->category,
            'subCategory' => $this->subCategory,
            'author' => $this->author,
            'link' => $this->link,
        ];
    }
}
