# TlynTask - Gold Trading API

TlynTask is a Gold Trading API built with Laravel 12. It supports functionalities like order creation, transaction processing, and order prioritization for buy and sell orders. The system processes orders based on price and ensures efficient transaction completion.

## Features

- **Order Management**: Create, view, and cancel buy/sell orders.
- **Transaction Management**: Process buy and sell transactions.
- **Order Matching**: Prioritize orders based on price for processing.
- **Order Cancellation**: Cancel pending orders by users.
- **Event-driven Architecture**: Notifications for order status changes.
- **Queue-based Processing**: Background processing for complex tasks like order matching and transaction creation.

## Requirements

- PHP >= 8.2.0
- Composer
- MySQL or MariaDB
- Redis (for queue management)
- Docker (for containerized setup)

## Installation

### 1. Clone the repository

Clone the project to your local machine:

```bash
git clone https://github.com/qazal-shafiei/tlynTask.git
cd tlynTask
