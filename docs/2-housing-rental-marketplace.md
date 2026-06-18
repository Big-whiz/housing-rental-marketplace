# Project Brief: Affordable Housing & Room Rental Marketplace with Verified Listings

## Executive Summary

Build a comprehensive rental marketplace platform connecting tenants and landlords in Accra, Ghana. The platform will enable landlords to list properties with verified information, while tenants can search, filter, and connect with property owners through an intuitive interface with integrated chat and payment capabilities.

**Timeline:** 1 Month MVP  
**Target Market:** Accra, Ghana  
**Platform:** Web Application (Mobile-responsive) + React Native App (optional)

---

## Project Objectives

- Create a trusted marketplace for rental properties in Accra
- Simplify the property search and listing process
- Enable secure communication between tenants and landlords
- Integrate payment solutions for deposits and viewing fees
- Provide verification mechanisms to build trust

---

## Core Features

### User Authentication & Roles
- **Phone OTP Authentication:** Secure login for both tenants and landlords
- **Role-Based Access:** Separate interfaces and permissions for tenants and landlords
- **Profile Management:** Basic user profiles with contact information

### Property Listings
- **Listing Creation (Landlords):**
  - Photo upload (maximum 3 photos per listing)
  - Property description (bedrooms, amenities, etc.)
  - Pricing information
  - Location selection via Google Maps pin
  - Property type and category selection
- **Listing Management:** Edit and delete listings from landlord dashboard

### Search & Discovery
- **Advanced Search Filters:**
  - Budget range (minimum and maximum)
  - Location (neighborhood/district)
  - Number of bedrooms
  - Property type (apartment, house, room, etc.)
- **Map View:** Visual map display of available properties
- **List View:** Grid/list layout with property cards
- **Favorites:** Save properties for later viewing

### Property Details
- **Comprehensive Listing Page:**
  - Photo gallery
  - Full description
  - Location map
  - Pricing details
  - Contact information
- **In-App Messaging:** Direct chat between tenant and landlord
- **WhatsApp Deep Link:** Alternative communication method

### Payment Integration
- **Mobile Money (MoMo) Integration:**
  - Holding deposits for property reservations
  - Viewing fees (if applicable)
  - Secure transaction processing
- **Payment History:** Track all transactions

### Verification System
- **Phone Verification:** SMS verification for all users
- **Admin Approval:** Toggle for listing verification status
- **Verified Badge:** Display verification status on listings

### Dashboards
- **Landlord Dashboard:**
  - View all listings
  - Edit/delete listings
  - View inquiries and messages
  - Track payment transactions
- **Tenant Dashboard:**
  - Saved favorites
  - Inquiry history
  - Payment history
  - Message threads

---

## Technical Stack

### Backend
- **Framework:** Laravel
- **Authentication:** Laravel Sanctum
- **Database:** MySQL
- **File Storage:** Cloudinary (or local storage for MVP)

### Frontend
- **Framework:** React (or Laravel Blade with Tailwind CSS)
- **Styling:** Tailwind CSS
- **Maps:** Google Maps API

### Third-Party Integrations
- Google Maps API
- Mobile Money (MoMo) SDK
- Cloudinary (for image storage and optimization)
- WhatsApp Business API (for deep links)

---

## Development Timeline

### Week 1: Foundation & Authentication
**Backend:**
- Set up Laravel project with authentication
- Design database schema:
  - Users table (with role: tenant/landlord)
  - Listings table (photos, description, price, location, etc.)
  - Messages table
  - Favorites table
  - Payments table
  - Verification status fields
- Configure photo storage (Cloudinary or local)
- Implement phone OTP authentication

**Frontend:**
- Set up project structure
- Create authentication screens (login/OTP)
- Design role-based routing

**Deliverables:**
- Working authentication with role separation
- Database schema deployed
- Basic user profiles functional

---

### Week 2: Listing & Search Features
**Features:**
- Listing creation form with photo upload
- Google Maps integration for location selection
- Search and filter functionality
- Property listing grid/list views
- Map view with property markers
- Property detail page

**Deliverables:**
- Landlords can create listings
- Tenants can search and filter properties
- Map view operational
- Property detail pages complete

---

### Week 3: Communication & Payments
**Features:**
- In-app messaging system (or WhatsApp deep link fallback)
- MoMo payment integration for deposits
- Payment history tracking
- Landlord dashboard (manage listings, view inquiries)
- Tenant dashboard (favorites, inquiries, payments)
- Admin approval queue for listings

**Deliverables:**
- Messaging/communication functional
- Payment flow working
- Both dashboards operational
- Admin can approve listings

---

### Week 4: Testing & Launch
**Activities:**
- Comprehensive testing across devices
- Bug fixes and UI/UX improvements
- Admin verification workflow refinement
- Beta launch preparation:
  - Deploy to staging environment
  - Prepare launch materials for Accra groups
  - Create user guides for tenants and landlords
- Social media and WhatsApp group outreach

**Deliverables:**
- Fully tested MVP
- Beta version live
- User documentation ready
- Launch materials prepared

---

## Risk Management

### Risk: Photo Upload Volume & Storage Costs
**Impact:** Medium  
**Mitigation:** 
- Limit photo uploads to 3 per listing
- Implement image compression before upload
- Use Cloudinary free tier initially, or local storage for MVP
- Set maximum file size limits

### Risk: Search Performance with Large Dataset
**Impact:** Medium  
**Mitigation:** 
- Start with simple MySQL queries with proper indexing
- Implement pagination from day one
- Optimize database queries
- Consider Elasticsearch in future iterations if needed

### Risk: Chat System Complexity
**Impact:** Low  
**Mitigation:** 
- Start with simple in-app messaging
- Use WhatsApp deep link as primary fallback
- Consider Firebase Chat or Laravel broadcasting for real-time features
- Keep MVP simple - basic message threading sufficient

### Risk: Payment Integration Delays
**Impact:** Medium  
**Mitigation:** 
- Begin MoMo SDK integration early in Week 1
- Have webview fallback ready
- Test payment flow thoroughly before Week 3
- Consider manual payment confirmation for MVP if needed

---

## Success Criteria

- Landlords can successfully create and manage listings
- Tenants can search, filter, and view properties effectively
- Communication between users works (chat or WhatsApp)
- Payment flow completes successfully
- Admin can verify listings
- Map view displays properties correctly
- Platform is mobile-responsive and user-friendly

---

## Post-MVP Considerations

- Advanced search filters (amenities, pet-friendly, etc.)
- Property tour scheduling
- Review and rating system
- Advanced analytics for landlords
- Email/SMS notifications
- Multi-language support
- Mobile app (React Native)
- Automated verification processes
- Integration with property management tools

---

## Notes

- Focus on trust-building through verification
- Ensure mobile-first design (most users will access via mobile)
- Consider local Accra neighborhoods and districts in search
- Plan for moderate listing volume initially
- Keep user flows simple and intuitive
- Prioritize security for payment transactions
