package main

import (
	"net/http" // Ensure this line is present

	"github.com/gin-gonic/gin" // Import the Gin framework package
	"cbt-api/config"
	"cbt-api/controller" 
)


func main() {
	config.ConnectDatabase()
	// router := gin.Default()
	// router.GET("/", rootHandler)
	// router.GET("/contoh", ContohHandler)   // Add a new route with the path "/contoh" and a handler function "ContohHandler"
	// router.GET("/books/:id/:title", booksHandler) // Add a new route with the path "/books
	// router.GET("/query", queryHandler)     // Add a new route with the path "/query
	// router.POST("/books", postBooksHandler)
	r := gin.Default()

    r.POST("/login", controller.Login)  // API login
	r.GET("/kursus-siswa/:id_siswa", controller.GetKursusBySiswa)

	r.Run("192.168.56.1:8080")

}

// Handler
func rootHandler(c *gin.Context) {
	c.JSON(http.StatusOK, gin.H{
		"name": "Andika Tampubolon",
		"bio":  "A Software Engineer",
	})
}

func ContohHandler(c *gin.Context) {
	c.JSON(http.StatusOK, gin.H{
		"class":      "D4 TRPL",
		"University": "Institut Teknologi Del",
	})
}

func booksHandler(c *gin.Context) {
	id := c.Param("id")
	title := c.Param("title")
	c.JSON(http.StatusOK, gin.H{"id": id, "title": title})
}

func queryHandler(c *gin.Context) {
	title := c.Query("title")
	price := c.Query("price")

	c.JSON(http.StatusOK, gin.H{"title": title, "price": price})
}

type BookInput struct {
	Title  string `json:"title" binding:"required"` 
	Price int `json:"price" binding:"required,number"`
	SubTitle string `json:"sub_title"`
}

func postBooksHandler(c *gin.Context) {
	//title, price	
	var bookInput BookInput

	err := c.ShouldBindJSON(&bookInput)
	if err != nil {
        c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
        return  // Return if there's an error binding JSON to the struct
    }

	c.JSON(http.StatusOK, gin.H{
		"title": bookInput.Title, 
		"price": bookInput.Price,
		"sub_title": bookInput.SubTitle,
	})
}
