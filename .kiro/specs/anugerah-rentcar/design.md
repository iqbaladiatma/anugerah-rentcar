# Design Document

## Overview

The Anugerah Rentcar System is a comprehensive car rental ERP system built using a "Modern Monolith" architecture approach. The system leverages Laravel 12 with Livewire 3 for reactive frontend components, providing high performance while maintaining rapid development capabilities. The system serves both internal staff through an admin panel and external customers through a public booking portal.

## Architecture

### Technology Stack

- **Backend Framework**: Laravel 12 (PHP 8.2+)
- **Frontend Logic**: Livewire 3 (Server-side reactive components)
- **Styling**: Tailwind CSS v4 (Custom design system)
- **Database**: MySQL 8.0+
- **File Storage**: Laravel Storage (local/cloud configurable)
- **Authentication**: Laravel Sanctum for API tokens, Laravel Auth for web sessions

### Key Libraries and Dependencies

- **maatwebsite/excel**: Excel report generation and export
- **barryvdh/laravel-dompdf**: PDF generation for invoices and documents
- **flatpickr**: Date and time input components
- **apexcharts**: Interactive dashboard charts and graphs
- **intervention/image**: Image processing for vehicle photos
- **spatie/laravel-permission**: Role and permission management

### System Architecture Patterns

- **Repository Pattern**: Data access abstraction for all entities
- **Service Layer**: Business logic encapsulation
- **Event-Driven Architecture**: For notifications and audit logging
- **Command Pattern**: For complex operations like booking calculations
- **Observer Pattern**: For model lifecycle events and audit trails

## Components and Interfaces

### Core Modules

#### 1. Fleet Management Module
- **VehicleController**: CRUD operations for vehicle management
- **VehicleService**: Business logic for availability calculations
- **MaintenanceService**: Maintenance scheduling and tracking
- **VehicleRepository**: Data access layer for vehicle operations

#### 2. Customer Relationship Module
- **CustomerController**: Customer management operations
- **CustomerService**: Member status and blacklist management
- **CustomerRepository**: Customer data access and search

#### 3. Booking Engine Module
- **BookingController**: Booking lifecycle management
- **BookingCalculatorService**: Real-time pricing calculations
- **AvailabilityService**: Vehicle availability checking
- **BookingRepository**: Booking data persistence

#### 4. Transaction Processing Module
- **CheckoutService**: Vehicle delivery processing
- **CheckinService**: Vehicle return processing
- **PenaltyCalculatorService**: Late fee calculations
- **InvoiceService**: Invoice generation and management

#### 5. Reporting Module
- **ReportController**: Report generation endpoints
- **ExportService**: Excel and PDF export functionality
- **AnalyticsService**: Business intelligence calculations
- **ReportRepository**: Report data aggregation

### Livewire Components

#### Admin Panel Components
- **VehicleAvailabilityTimeline**: Interactive Gantt chart for availability
- **BookingCalculator**: Real-time pricing calculator
- **VehicleInspectionForm**: Check-in/check-out forms with photo upload
- **DashboardStats**: Real-time statistics and notifications
- **CustomerSearch**: Advanced customer filtering and search

#### Customer Portal Components
- **VehicleSearchWidget**: Public vehicle search interface
- **BookingWizard**: Multi-step booking process
- **CustomerDashboard**: Customer booking history and status
- **DocumentUpload**: KTP and license verification

### API Interfaces

#### Internal APIs (Livewire AJAX)
- **Availability API**: Real-time availability checking
- **Pricing API**: Dynamic pricing calculations
- **Validation API**: Form validation and business rules
- **Notification API**: Real-time notifications and alerts

#### External APIs (Optional Future Enhancement)
- **Payment Gateway Integration**: For online payments
- **SMS/WhatsApp API**: Customer notifications
- **Google Maps API**: Location services for delivery

## Data Models

### Core Entities

#### Settings Model
```php
- id: bigint (primary key)
- company_name: string
- company_address: text
- company_phone: string
- company_logo: string (file path)
- late_penalty_per_hour: decimal(8,2)
- buffer_time_hours: integer (default: 3)
- member_discount_percentage: decimal(5,2)
- created_at: timestamp
- updated_at: timestamp
```

#### User Model (Extended Laravel User)
```php
- id: bigint (primary key)
- name: string
- email: string
- phone: string
- role: enum('admin', 'staff', 'driver')
- is_active: boolean
- email_verified_at: timestamp
- password: string (hashed)
- remember_token: string
- created_at: timestamp
- updated_at: timestamp
```

#### Customer Model
```php
- id: bigint (primary key)
- name: string
- phone: string
- email: string (nullable)
- nik: string (unique)
- ktp_photo: string (file path)
- sim_photo: string (file path)
- address: text
- is_member: boolean (default: false)
- member_discount: decimal(5,2) (nullable)
- is_blacklisted: boolean (default: false)
- blacklist_reason: text (nullable)
- created_at: timestamp
- updated_at: timestamp
```

#### Car Model
```php
- id: bigint (primary key)
- license_plate: string (unique)
- brand: string
- model: string
- year: integer
- color: string
- stnk_number: string
- stnk_expiry: date
- last_oil_change: date
- oil_change_interval_km: integer
- current_odometer: integer
- daily_rate: decimal(10,2)
- weekly_rate: decimal(10,2)
- driver_fee_per_day: decimal(8,2)
- photo_front: string (file path)
- photo_side: string (file path)
- photo_back: string (file path)
- status: enum('available', 'rented', 'maintenance', 'inactive')
- created_at: timestamp
- updated_at: timestamp
```

#### Booking Model
```php
- id: bigint (primary key)
- booking_number: string (unique)
- customer_id: bigint (foreign key)
- car_id: bigint (foreign key)
- driver_id: bigint (foreign key, nullable)
- start_date: datetime
- end_date: datetime
- actual_return_date: datetime (nullable)
- pickup_location: string
- return_location: string
- with_driver: boolean
- is_out_of_town: boolean
- out_of_town_fee: decimal(8,2) (default: 0)
- base_amount: decimal(10,2)
- driver_fee: decimal(8,2)
- member_discount: decimal(8,2) (default: 0)
- late_penalty: decimal(8,2) (default: 0)
- total_amount: decimal(10,2)
- deposit_amount: decimal(8,2)
- payment_status: enum('pending', 'partial', 'paid', 'refunded')
- booking_status: enum('pending', 'confirmed', 'active', 'completed', 'cancelled')
- notes: text (nullable)
- created_at: timestamp
- updated_at: timestamp
```

#### CarInspection Model
```php
- id: bigint (primary key)
- booking_id: bigint (foreign key)
- inspection_type: enum('checkout', 'checkin')
- fuel_level: enum('empty', 'quarter', 'half', 'three_quarter', 'full')
- odometer_reading: integer
- exterior_condition: json (damage descriptions)
- interior_condition: json (damage descriptions)
- photos: json (array of file paths)
- inspector_signature: string (file path, nullable)
- customer_signature: string (file path, nullable)
- notes: text (nullable)
- created_at: timestamp
- updated_at: timestamp
```

#### Maintenance Model
```php
- id: bigint (primary key)
- car_id: bigint (foreign key)
- maintenance_type: enum('routine', 'repair', 'inspection')
- description: text
- cost: decimal(10,2)
- service_date: date
- next_service_date: date (nullable)
- odometer_at_service: integer
- service_provider: string
- receipt_photo: string (file path, nullable)
- created_at: timestamp
- updated_at: timestamp
```

#### Expense Model
```php
- id: bigint (primary key)
- category: enum('salary', 'utilities', 'supplies', 'marketing', 'other')
- description: string
- amount: decimal(10,2)
- expense_date: date
- receipt_photo: string (file path, nullable)
- created_by: bigint (foreign key to users)
- created_at: timestamp
- updated_at: timestamp
```

### Relationships

- Customer hasMany Bookings
- Car hasMany Bookings, hasMany Maintenances
- Booking belongsTo Customer, belongsTo Car, belongsTo User (driver)
- Booking hasMany CarInspections
- User hasMany Bookings (as driver), hasMany Expenses (as creator)

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system-essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

Based on the prework analysis, I'll now perform a property reflection to eliminate redundancy and consolidate related properties:

**Property Reflection:**
- Properties 1.1, 2.1, 9.1, 9.2 all test basic CRUD data persistence - can be consolidated into a general data persistence property
- Properties 2.2, 4.3 both test member discount application - can be combined
- Properties 3.3, 3.4, 7.1 all test availability calculation logic - can be consolidated
- Properties 4.1, 4.4, 7.2 all test pricing calculation consistency - can be combined
- Properties 5.3, 5.4 both test late fee calculations - can be consolidated
- Properties 6.1, 6.3, 6.4, 9.3, 9.4 all test report generation accuracy - can be grouped
- Properties 1.2, 8.5 both test audit logging - can be combined

### Core Correctness Properties

**Property 1: Data Persistence Integrity**
*For any* valid entity (vehicle, customer, expense, maintenance record), when created or updated with complete required fields, the system should store all provided data accurately and retrieve it identically
**Validates: Requirements 1.1, 2.1, 2.5, 9.1, 9.2**

**Property 2: Vehicle Availability Calculation**
*For any* date range and set of existing bookings, the system should exclude vehicles with active bookings during that period and include 3-hour buffer time after each return
**Validates: Requirements 3.3, 3.4, 7.1**

**Property 3: Pricing Calculation Consistency**
*For any* booking parameters (vehicle, duration, driver, member status, out-of-town), the pricing calculation should always produce the same result using the formula: (Vehicle Rate × Duration) + (Driver Fee × Duration) + Out-of-town Fee - Member Discount
**Validates: Requirements 4.1, 4.4, 7.2**

**Property 4: Member Discount Application**
*For any* customer with member status and configured discount percentage, all booking calculations should automatically apply the discount amount
**Validates: Requirements 2.2, 4.3**

**Property 5: Late Fee Calculation Accuracy**
*For any* vehicle return that exceeds scheduled return time, the system should calculate penalties using configured hourly rates for delays under 24 hours, and daily extension rates for longer delays
**Validates: Requirements 5.3, 5.4**

**Property 6: Blacklist Access Control**
*For any* customer marked as blacklisted, the system should prevent new booking creation while maintaining access to existing booking history
**Validates: Requirements 2.3**

**Property 7: Timeline Display Accuracy**
*For any* selected date range, the timeline view should display all vehicle bookings with correct time periods, customer information, and appropriate color coding for different statuses
**Validates: Requirements 3.1, 3.2, 3.5**

**Property 8: Document Generation Completeness**
*For any* booking transaction, the system should generate all required documents (invoices, delivery documents, final invoices) with complete information including all charges, discounts, and company details
**Validates: Requirements 4.5, 5.1, 5.5**

**Property 9: Report Data Accuracy**
*For any* report generation request, the system should include all relevant data within specified filters and calculate metrics (profit/loss, utilization rates, revenue) using correct formulas
**Validates: Requirements 6.1, 6.3, 6.4, 9.3, 9.4**

**Property 10: Export Format Consistency**
*For any* report data, both Excel and PDF export formats should contain identical information with proper formatting
**Validates: Requirements 6.2**

**Property 11: Search and Filter Accuracy**
*For any* search criteria (customer filters, report filters, vehicle search), the system should return only results that match all specified criteria
**Validates: Requirements 2.4, 6.5**

**Property 12: Configuration Propagation**
*For any* system setting change (company info, penalty rates, discount percentages), the new values should be applied to all future calculations and document generation
**Validates: Requirements 8.1, 8.2, 8.4**

**Property 13: Audit Trail Completeness**
*For any* data modification or system configuration change, the system should create audit log entries with timestamp, user identification, and change details
**Validates: Requirements 1.2, 8.5**

**Property 14: Role-Based Access Control**
*For any* user with assigned role (admin, staff, driver), the system should enforce appropriate access permissions and prevent unauthorized operations
**Validates: Requirements 8.3**

**Property 15: Notification Trigger Accuracy**
*For any* condition requiring notification (maintenance due, registration expiry, pending confirmations, overdue payments), the system should generate alerts with complete information and clear action items
**Validates: Requirements 1.3, 10.1, 10.2, 10.3, 10.4, 10.5**

**Property 16: Document Upload Validation**
*For any* file upload operation (vehicle photos, customer documents), the system should validate file formats, enforce security requirements, and store files with proper naming conventions
**Validates: Requirements 1.5, 7.3**

**Property 17: Booking State Consistency**
*For any* booking lifecycle transition (pending → confirmed → active → completed), the system should maintain data consistency and update related entity statuses appropriately
**Validates: Requirements 4.5, 5.2**

**Property 18: Time Calculation Accuracy**
*For any* time-based operation (return time comparison, maintenance scheduling, notification timing), the system should perform accurate date/time calculations accounting for business rules
**Validates: Requirements 5.2, 9.5**

## Error Handling

### Input Validation Strategy
- **Client-Side Validation**: Livewire real-time validation for immediate user feedback
- **Server-Side Validation**: Laravel Form Requests for comprehensive validation
- **Database Constraints**: Foreign key constraints and unique indexes for data integrity
- **File Upload Security**: MIME type validation, file size limits, and secure storage

### Exception Handling Patterns
- **Custom Exception Classes**: Domain-specific exceptions for business rule violations
- **Global Exception Handler**: Centralized error logging and user-friendly error messages
- **Transaction Rollback**: Database transaction management for complex operations
- **Graceful Degradation**: Fallback mechanisms for external service failures

### Error Recovery Mechanisms
- **Retry Logic**: Automatic retry for transient failures (file uploads, external APIs)
- **Data Backup**: Regular database backups and point-in-time recovery
- **Audit Trail**: Complete operation logging for debugging and recovery
- **User Notification**: Clear error messages with suggested corrective actions

## Testing Strategy

### Dual Testing Approach

The system will implement both unit testing and property-based testing to ensure comprehensive coverage:

**Unit Testing**:
- Specific examples demonstrating correct behavior
- Edge cases and boundary conditions
- Integration points between components
- Error conditions and exception handling
- Mock external dependencies for isolated testing

**Property-Based Testing**:
- Universal properties verified across all valid inputs
- Minimum 100 iterations per property test
- Smart generators for realistic test data
- Each property test tagged with design document reference

### Property-Based Testing Framework

**Framework**: PHPUnit with Eris (PHP property-based testing library)
**Configuration**: Minimum 100 iterations per property test
**Tagging Format**: Each test must include comment: `**Feature: anugerah-rentcar, Property {number}: {property_text}**`

### Testing Requirements

**Unit Tests**:
- Model validation and relationships
- Service layer business logic
- Controller endpoint behavior
- Livewire component interactions
- Repository data access methods

**Property-Based Tests**:
- Each correctness property implemented as single property test
- Smart generators for entities (vehicles, customers, bookings)
- Realistic constraint-based test data generation
- Cross-component integration testing

**Integration Tests**:
- Complete booking workflow testing
- File upload and storage operations
- Report generation and export functionality
- Authentication and authorization flows
- Database transaction integrity

### Test Data Management

**Factories and Seeders**:
- Laravel Model Factories for consistent test data
- Database seeders for development environment
- Realistic data generation using Faker library
- Constraint-aware generators for business rules

**Test Database**:
- Separate test database configuration
- Database transactions for test isolation
- Migration rollback capabilities
- Performance testing with realistic data volumes

## Performance Considerations

### Database Optimization
- **Indexing Strategy**: Composite indexes for common query patterns
- **Query Optimization**: Eager loading for N+1 query prevention
- **Connection Pooling**: Optimized database connection management
- **Caching Layer**: Redis for session storage and query result caching

### Frontend Performance
- **Livewire Optimization**: Lazy loading and wire:loading states
- **Asset Optimization**: Vite for JavaScript and CSS bundling
- **Image Optimization**: Automatic image compression and resizing
- **CDN Integration**: Static asset delivery optimization

### Scalability Considerations
- **Queue System**: Background job processing for heavy operations
- **File Storage**: Scalable storage solution (local/S3 configurable)
- **Session Management**: Database or Redis session storage
- **Monitoring**: Application performance monitoring and logging

## Security Measures

### Authentication and Authorization
- **Multi-Factor Authentication**: Optional 2FA for admin accounts
- **Role-Based Permissions**: Granular permission system using Spatie Laravel Permission
- **Session Security**: Secure session configuration and timeout
- **Password Security**: Bcrypt hashing with complexity requirements

### Data Protection
- **Input Sanitization**: XSS prevention and SQL injection protection
- **File Upload Security**: MIME type validation and virus scanning
- **Data Encryption**: Sensitive data encryption at rest
- **HTTPS Enforcement**: SSL/TLS for all communications

### Audit and Compliance
- **Activity Logging**: Comprehensive user action logging
- **Data Retention**: Configurable data retention policies
- **Backup Security**: Encrypted backup storage
- **Access Monitoring**: Failed login attempt tracking and alerting

## Deployment Architecture

### Environment Configuration
- **Development**: Local development with SQLite/MySQL
- **Staging**: Production-like environment for testing
- **Production**: Optimized configuration with monitoring

### Infrastructure Requirements
- **Web Server**: Nginx or Apache with PHP 8.2+
- **Database**: MySQL 8.0+ with proper indexing
- **Storage**: Local filesystem or cloud storage (S3 compatible)
- **Monitoring**: Application and infrastructure monitoring tools

### Deployment Process
- **Version Control**: Git-based deployment workflow
- **Database Migration**: Automated migration deployment
- **Asset Compilation**: Automated asset building and optimization
- **Health Checks**: Post-deployment verification procedures