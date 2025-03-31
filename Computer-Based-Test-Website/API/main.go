package main

import (
    "API/config"
    "API/migrations"
    "API/routes"
    "log"
)

func main() {
    if err := config.ConnectDB(); err != nil {
        log.Fatal("Failed to connect to database:", err)
    }

    if err := migrations.RunMigrations(config.DB); err != nil {
        log.Fatal("Failed to run database migrations:", err)
    }

    r := routes.SetupRouter()

    log.Println("Server is running on port 8080")
    if err := r.Run("127.0.0.1:8080"); err != nil {
        log.Fatal("Failed to start server:", err)
    }
}