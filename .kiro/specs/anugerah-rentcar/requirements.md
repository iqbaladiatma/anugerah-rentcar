# Requirements Document

## Introduction

The Anugerah Rentcar System is a comprehensive car rental ERP system designed for single-headquarters operations. The system provides fleet management, real-time booking engine, financial reporting, and customer relationship management capabilities. It features both back-office administration tools and front-office customer booking interfaces, built using modern web technologies including Laravel 12, Livewire 3, and MySQL.

## Glossary

- **System**: The Anugerah Rentcar System
- **Admin Panel**: Back-office interface for staff and administrators
- **Customer Portal**: Front-office website for public booking
- **Fleet**: Collection of rental vehicles managed by the system
- **Booking**: A rental transaction from start to completion
- **Check-Out**: Process when customer takes vehicle possession
- **Check-In**: Process when customer returns vehicle
- **Member**: Customer with special discount privileges
- **Blacklist**: Restricted customer status preventing future bookings
- **Late Fine**: Penalty charges for overdue vehicle returns
- **Buffer Time**: Additional 3-hour period after return for vehicle cleaning
- **Active Booking**: Confirmed rental where vehicle is currently with customer
- **Available Vehicle**: Vehicle ready for new bookings
- **Timeline View**: Gantt chart showing vehicle availability schedules

## Requirements

### Requirement 1

**User Story:** As a rental staff member, I want to manage vehicle fleet information, so that I can maintain accurate records of all rental vehicles and their conditions.

#### Acceptance Criteria

1. WHEN staff adds a new vehicle, THE System SHALL store complete vehicle details including license plate, registration document, maintenance schedule, and three-angle photos
2. WHEN staff updates vehicle information, THE System SHALL maintain historical records of changes for audit purposes
3. WHEN a vehicle requires maintenance, THE System SHALL display reminder notifications based on oil change dates and registration renewal schedules
4. WHEN staff views vehicle details, THE System SHALL show current status, maintenance history, and upcoming service requirements
5. WHERE vehicle photos are uploaded, THE System SHALL validate image formats and store them securely with proper file naming

### Requirement 2

**User Story:** As a rental staff member, I want to manage customer information and relationships, so that I can provide personalized service and maintain customer security.

#### Acceptance Criteria

1. WHEN staff registers a new customer, THE System SHALL capture complete identity information including NIK, KTP photo, and contact details
2. WHEN staff assigns member status to a customer, THE System SHALL automatically apply configured discount percentages to future bookings
3. WHEN staff marks a customer as blacklisted, THE System SHALL prevent that customer from creating new bookings
4. WHEN staff searches for customers, THE System SHALL provide filtering by name, phone number, member status, and blacklist status
5. WHEN customer data is updated, THE System SHALL maintain data integrity and validation rules for all required fields

### Requirement 3

**User Story:** As a rental staff member, I want to check vehicle availability in real-time, so that I can efficiently schedule bookings without conflicts.

#### Acceptance Criteria

1. WHEN staff selects date ranges, THE System SHALL display a timeline view showing all vehicles and their booking schedules
2. WHEN staff hovers over booking blocks in timeline, THE System SHALL show customer name and booking details
3. WHEN checking availability, THE System SHALL exclude vehicles that have active bookings during the requested period
4. WHEN calculating availability, THE System SHALL include three-hour buffer time after each return for vehicle cleaning
5. WHEN displaying timeline, THE System SHALL use color coding to distinguish between available, booked, and maintenance periods

### Requirement 4

**User Story:** As a rental staff member, I want to create and manage bookings with automatic pricing calculations, so that I can process rentals efficiently and accurately.

#### Acceptance Criteria

1. WHEN staff creates a booking, THE System SHALL calculate total cost using formula: (Vehicle Rate × Duration) + (Driver Fee × Duration) + Out-of-town Fee - Member Discount
2. WHEN staff selects weekly packages, THE System SHALL apply package pricing instead of daily rates
3. WHEN customer has member status, THE System SHALL automatically apply configured discount percentage
4. WHEN booking details change, THE System SHALL recalculate pricing in real-time
5. WHEN booking is confirmed, THE System SHALL generate invoice and update vehicle availability status

### Requirement 5

**User Story:** As a rental staff member, I want to process vehicle check-out and check-in procedures, so that I can properly document vehicle condition and calculate final charges.

#### Acceptance Criteria

1. WHEN processing check-out, THE System SHALL capture vehicle condition photos and generate delivery document
2. WHEN processing check-in, THE System SHALL record actual return time and compare with scheduled return time
3. WHEN vehicle is returned late, THE System SHALL calculate late fees using configured hourly penalty rates
4. WHEN late period exceeds 24 hours, THE System SHALL calculate additional charges as daily rental extension
5. WHEN check-in is completed, THE System SHALL generate final invoice including all charges and deduct deposit amount

### Requirement 6

**User Story:** As a rental administrator, I want to generate comprehensive reports and export data, so that I can analyze business performance and maintain financial records.

#### Acceptance Criteria

1. WHEN administrator requests financial reports, THE System SHALL generate profit/loss statements including rental income and operational expenses
2. WHEN administrator exports data, THE System SHALL provide Excel and PDF formats for all report types
3. WHEN generating customer reports, THE System SHALL include booking history, payment status, and member statistics
4. WHEN creating vehicle reports, THE System SHALL show utilization rates, maintenance costs, and revenue per vehicle
5. WHEN filtering reports, THE System SHALL support date ranges, customer types, and vehicle categories

### Requirement 7

**User Story:** As a customer, I want to search and book vehicles online, so that I can make reservations conveniently without visiting the office.

#### Acceptance Criteria

1. WHEN customer searches for vehicles, THE System SHALL display only available vehicles for the selected date range
2. WHEN customer selects a vehicle, THE System SHALL show real-time pricing including all applicable fees
3. WHEN customer creates booking, THE System SHALL require identity verification through KTP and driving license upload
4. WHEN customer completes booking, THE System SHALL send confirmation with booking details and payment instructions
5. WHEN customer logs in, THE System SHALL display booking history and current reservation status

### Requirement 8

**User Story:** As a system administrator, I want to configure system settings and manage user accounts, so that I can maintain system security and operational parameters.

#### Acceptance Criteria

1. WHEN administrator updates company information, THE System SHALL reflect changes in all generated documents and invoices
2. WHEN administrator sets penalty rates, THE System SHALL apply new rates to future late fee calculations
3. WHEN administrator manages user accounts, THE System SHALL support role-based access control for admin, staff, and driver roles
4. WHEN administrator configures member discounts, THE System SHALL validate percentage ranges and apply to eligible customers
5. WHEN system settings are modified, THE System SHALL log all changes with timestamp and user identification

### Requirement 9

**User Story:** As a rental business owner, I want to track operational expenses and maintenance costs, so that I can calculate accurate profit margins and make informed business decisions.

#### Acceptance Criteria

1. WHEN staff records maintenance expenses, THE System SHALL categorize costs and associate them with specific vehicles
2. WHEN staff enters operational expenses, THE System SHALL support multiple expense categories including utilities, salaries, and supplies
3. WHEN calculating profitability, THE System SHALL deduct all recorded expenses from rental revenue
4. WHEN viewing expense reports, THE System SHALL provide monthly and yearly summaries with category breakdowns
5. WHEN maintenance is scheduled, THE System SHALL track service history and predict future maintenance needs

### Requirement 10

**User Story:** As a rental staff member, I want to receive automated notifications and reminders, so that I can proactively manage vehicle maintenance and customer communications.

#### Acceptance Criteria

1. WHEN vehicle maintenance is due, THE System SHALL display dashboard notifications with vehicle details and service requirements
2. WHEN vehicle registration expires within 30 days, THE System SHALL alert administrators with renewal reminders
3. WHEN booking confirmation is pending, THE System SHALL notify staff of required actions
4. WHEN customer payment is overdue, THE System SHALL generate follow-up notifications with payment details
5. WHEN system generates notifications, THE System SHALL provide clear action items and relevant contact information