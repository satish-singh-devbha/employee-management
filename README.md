**Task: Employee Management System**

**Objective:**
Build a basic employee management system with admin and employee roles. Admins should have the ability to add, edit, and delete employees. Employees can only view the list of other employees. Additionally, implement a feature to send a welcome email through a queue when a new employee is created. Configure email settings with either Mailtrap or any local/working SMTP credentials.

**Instructions:**

1. Clone the Git repository to your local machine.

   ```bash
   git clone [repository_url]
   ```

2. Install Laravel dependencies using the following command:

   ```bash
   php artisan composer install
   ```

3. After installing dependencies, run the npm build command:

   ```bash
   npm run build
   ```

4. Execute the following Laravel commands to set up the database and seed initial data:

   ```bash
   php artisan migrate --seed
   ```

5. Launch the application.

6. Default admin credentials:

   - Email: admin@admin.com
   - Password: 12345678

7. For employee data:

   - You can seed employee data by uncommenting the relevant section in the `DatabaseSeeder` file and then running:

     ```bash
     php artisan db:seed
     ```

   - Alternatively, you can manually create employee data using the frontend interface.

8. Configure email settings:

   - Add Mailtrap or any local/working SMTP credentials to the `.env` file for the email queue to function.

9. Test the email functionality by creating a new employee and verifying that a welcome email is sent via the queue.

10. For tests you can run:

    ```bash
     php artisan test
     ```

**Note:** Ensure that you have the necessary permissions and configurations for the database and email settings.

Feel free to reach out if you have any questions or need further clarification.