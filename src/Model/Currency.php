<?php

class Currency
{
	private string $code;

	private string $name;

	private float $rate;

	private DateTime $dateTime;

	private float $amount;

	private string | null $flagCode;

	/**
	 * @param string $code
	 * @param string $name
	 * @param float $rate
	 * @param DateTime $dateTime
	 * @param float $amount
	 * @param string|null $flagCode
	 */
	public function __construct(
		?string $flagCode,
		string $code,
		string $name,
		float $rate,
		DateTime $dateTime,
		float $amount
	)
	{
		$this->code = $code;
		$this->name = $name;
		$this->rate = $rate;
		$this->dateTime = $dateTime;
		$this->amount = $amount;
		$this->flagCode = $flagCode;
	}

	/**
	 * @return float
	 */
	public function getRate(): float
	{
		return $this->rate;
	}

	/**
	 * @param float $rate
	 */
	public function setRate(float $rate): void
	{
		$this->rate = $rate;
	}

	/**
	 * @return DateTime
	 */
	public function getDateTime(): DateTime
	{
		return $this->dateTime;
	}

	/**
	 * @param DateTime $dateTime
	 */
	public function setDateTime(DateTime $dateTime): void
	{
		$this->dateTime = $dateTime;
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
	 * @return string
	 */
	public function getCode(): string
	{
		return $this->code;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return string|null
	 */
	public function getFlagCode(): ?string
	{
		return $this->flagCode;
	}


}