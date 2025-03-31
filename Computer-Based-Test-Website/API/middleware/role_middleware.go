package middleware

import (
	"net/http"
	"github.com/gin-gonic/gin"
)

func RoleMiddleware(role string) gin.HandlerFunc {
	return func(c *gin.Context) {

		hasRole := true 

		if !hasRole {
			c.JSON(http.StatusForbidden, gin.H{"error": "Forbidden"})
			c.Abort()
			return
		}

		c.Next()
	}
}